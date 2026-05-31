<?php

namespace App\Http\Controllers;

use App\Models\RegistroPatrimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookmarkController extends Controller
{
    public function index()
    {
        $registros = Auth::user()->marcadores()->paginate(12);
        
        return view('bookmarks.index', compact('registros'));
    }

    public function toggle(RegistroPatrimonial $registro)
    {
        $user = Auth::user();
        
        if ($user->marcadores()->where('registro_id', $registro->id)->exists()) {
            $user->marcadores()->detach($registro->id);
            $message = 'Documento removido de tus marcadores.';
        } else {
            $user->marcadores()->attach($registro->id);
            $message = 'Documento guardado en tus marcadores.';
        }

        return back()->with('success', $message);
    }
}
