<?php

namespace App\Http\Controllers;

use App\Models\Comentario;
use App\Models\RegistroPatrimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComentarioController extends Controller
{
    public function store(Request $request, RegistroPatrimonial $registro)
    {
        $request->validate([
            'contenido' => 'required|string|max:1000',
        ]);

        $registro->comentarios()->create([
            'user_id' => Auth::id(),
            'contenido' => $request->contenido,
        ]);

        return back()->with('success', 'Comentario añadido exitosamente.');
    }

    public function destroy(Comentario $comentario)
    {
        if (Auth::user()->isAdmin() || Auth::id() === $comentario->user_id) {
            $comentario->delete();
            return back()->with('success', 'Comentario eliminado.');
        }

        abort(403, 'No tienes permiso para eliminar este comentario.');
    }
}
