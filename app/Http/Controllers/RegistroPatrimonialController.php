<?php

namespace App\Http\Controllers;

use App\Models\RegistroPatrimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RegistroPatrimonialController extends Controller
{
    public function index(Request $request)
    {
        $query = RegistroPatrimonial::with('categoria');

        if ($request->has('buscar')) {
            $termino = '%' . $request->buscar . '%';
            $query->where('titulo', 'ilike', $termino)
                  ->orWhere('descripcion', 'ilike', $termino);
        }

        if ($request->has('categoria')) {
            $query->where('id_categoria', $request->categoria);
        }

        $registros = $query->orderBy('fecha_suceso', 'desc')->paginate(12);

        return view('registros.index', compact('registros'));
    }

    public function show(RegistroPatrimonial $registro)
    {
        $registro->load(['categoria', 'comentarios.user', 'autor', 'archivos']);
        return view('registros.show', compact('registro'));
    }

    public function create()
    {
        $categorias = \App\Models\Categoria::all();
        return view('registros.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo'       => 'required|string|max:255',
            'descripcion'  => 'required|string',
            'fecha_suceso' => 'required|date',
            'id_categoria' => 'required|exists:categorias,id',
            'archivo'      => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
        ]);

        $archivo = $request->file('archivo');
        $rutaDestino = 'patrimonio/' . date('Y');
        $path = $archivo->store($rutaDestino, 'public');
        $urlRecurso = Storage::disk('public')->url($path);

        $registro = RegistroPatrimonial::create([
            'titulo'          => $request->titulo,
            'descripcion'     => $request->descripcion,
            'fecha_suceso'    => $request->fecha_suceso,
            'id_categoria'    => $request->id_categoria,
            'url_recurso'     => $urlRecurso,
            'tipo_archivo'    => $archivo->getClientMimeType(),
            'peso_archivo_kb' => round($archivo->getSize() / 1024),
            'created_by'      => \Illuminate\Support\Facades\Auth::id(),
        ]);

        // También guardar en la tabla archivos (relación 1:N)
        $registro->archivos()->create([
            'url_recurso'     => $urlRecurso,
            'nombre_original' => $archivo->getClientOriginalName(),
            'tipo_archivo'    => $archivo->getClientMimeType(),
            'peso_archivo_kb' => round($archivo->getSize() / 1024),
        ]);

        return redirect()->route('registros.index')
            ->with('success', 'Documento histórico preservado correctamente.');
    }

    public function destroy(RegistroPatrimonial $registro)
    {
        $registro->delete();

        return redirect()->route('registros.index')
            ->with('success', 'Registro archivado. Puede ser restaurado por un administrador.');
    }
}
