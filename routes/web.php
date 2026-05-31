<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

use App\Http\Controllers\HomeController;
use App\Http\Controllers\RegistroPatrimonialController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\BookmarkController;

// Rutas Públicas
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/archivo', [RegistroPatrimonialController::class, 'index'])->name('registros.index');
Route::get('/registro/{registro}', [RegistroPatrimonialController::class, 'show'])->name('registros.show');

// Rutas de Autenticación (Invitados)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/registro', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/registro', [AuthController::class, 'register']);
});

// Rutas Protegidas (Autenticados)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Marcadores
    Route::get('/mis-marcadores', [BookmarkController::class, 'index'])->name('bookmarks.index');
    Route::post('/registro/{registro}/marcar', [BookmarkController::class, 'toggle'])->name('bookmarks.toggle');

    // Comentarios
    Route::post('/registro/{registro}/comentarios', [ComentarioController::class, 'store'])->name('comentarios.store');
    Route::delete('/comentarios/{comentario}', [ComentarioController::class, 'destroy'])->name('comentarios.destroy');

    // Publicadores y Administradores
    Route::middleware('role:administrador,publicador')->group(function () {
        Route::get('/ingesta', [RegistroPatrimonialController::class, 'create'])->name('registros.create');
        Route::post('/ingesta', [RegistroPatrimonialController::class, 'store'])->name('registros.store');
    });

    // Solo Administradores
    Route::middleware('role:administrador')->group(function () {
        Route::delete('/registro/{registro}', [RegistroPatrimonialController::class, 'destroy'])->name('registros.destroy');
    });
});
