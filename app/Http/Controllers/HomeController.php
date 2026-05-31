<?php

namespace App\Http\Controllers;

use App\Models\RegistroPatrimonial;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // 1. Artículos Recientes (Últimos 4 ingresados)
        $recientes = RegistroPatrimonial::with('categoria')
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();

        // 2. Artículos Relevantes (Los 4 más guardados en marcadores)
        $relevantes = RegistroPatrimonial::with('categoria')
            ->withCount('marcadosPor')
            ->orderByDesc('marcados_por_count')
            ->orderBy('created_at', 'desc') // Desempate
            ->take(4)
            ->get();

        // 3. Efemérides: Tal día como hoy
        $hoy = now();
        $efemerides = RegistroPatrimonial::with('categoria')
            ->whereMonth('fecha_suceso', $hoy->month)
            ->whereDay('fecha_suceso', $hoy->day)
            ->take(2)
            ->get();

        return view('home', compact('recientes', 'relevantes', 'efemerides'));
    }
}
