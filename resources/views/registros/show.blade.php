@extends('layouts.app')

@section('content')
<div class="mb-6">
    <a href="{{ route('registros.index') }}" class="text-navy-900 hover:text-gold-600 font-medium text-sm flex items-center transition-colors">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Volver a la Galería
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Columna Principal: Detalles del Documento -->
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <!-- Visor del Recurso -->
            <div class="bg-parchment-100 border-b border-gray-200 p-4 flex justify-center items-center min-h-[400px]">
                @if(Str::startsWith($registro->tipo_archivo, 'image/'))
                    <img src="{{ $registro->url_recurso }}" alt="{{ $registro->titulo }}" class="max-w-full max-h-[600px] object-contain rounded shadow-sm">
                @else
                    <div class="text-center">
                        <svg class="w-24 h-24 mx-auto text-red-700 opacity-80 mb-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14H9V8h2v8zm5 0h-2V8h2v8z"/></svg>
                        <p class="text-navy-900 font-bold mb-4">Documento PDF o Archivo No Visualizable</p>
                        <a href="{{ $registro->url_recurso }}" target="_blank" class="inline-flex items-center bg-gold-600 hover:bg-gold-500 text-navy-950 px-4 py-2 rounded-md text-sm font-bold shadow-sm transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            Descargar / Visualizar Original
                        </a>
                    </div>
                @endif
            </div>
            
            <div class="p-6">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <div class="text-xs text-gold-600 font-bold uppercase tracking-wider mb-2">{{ $registro->categoria->nombre }}</div>
                        <h1 class="text-2xl font-merriweather font-bold text-navy-900 leading-tight mb-2">{{ $registro->titulo }}</h1>
                        <div class="flex flex-wrap items-center text-sm text-gray-500 mb-4 gap-y-2">
                            <span class="flex items-center mr-3">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                Ingresado por: {{ $registro->autor->name ?? 'Sistema' }}
                            </span>
                            <span class="mx-1 hidden md:inline">•</span>
                            <span class="flex items-center mx-3">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                Suceso: {{ $registro->fecha_suceso->format('d M, Y') }}
                            </span>
                            <span class="mx-1 hidden md:inline">•</span>
                            <span class="flex items-center ml-3">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                {{ $registro->peso_archivo_kb }} KB
                            </span>
                        </div>
                    </div>
                    
                    @auth
                        @php
                            $isBookmarked = Auth::user()->marcadores()->where('registro_id', $registro->id)->exists();
                        @endphp
                        <form action="{{ route('bookmarks.toggle', $registro) }}" method="POST">
                            @csrf
                            <button type="submit" class="flex flex-col items-center justify-center p-2 rounded-md hover:bg-gray-50 transition-colors {{ $isBookmarked ? 'text-gold-600' : 'text-gray-400 hover:text-gold-600' }}" title="{{ $isBookmarked ? 'Quitar de Marcadores' : 'Guardar en Marcadores' }}">
                                <svg class="w-8 h-8" fill="{{ $isBookmarked ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                                </svg>
                                <span class="text-xs font-semibold mt-1">{{ $isBookmarked ? 'Guardado' : 'Guardar' }}</span>
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="flex flex-col items-center justify-center p-2 rounded-md hover:bg-gray-50 transition-colors text-gray-400 hover:text-gold-600" title="Inicia sesión para guardar">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path></svg>
                            <span class="text-xs font-semibold mt-1">Guardar</span>
                        </a>
                    @endauth
                </div>
                
                <div class="prose prose-sm max-w-none text-gray-700">
                    <p class="whitespace-pre-line">{{ $registro->descripcion }}</p>
                </div>

                @if($registro->archivos->count() > 1)
                    <div class="mt-8 border-t border-gray-200 pt-6">
                        <h4 class="text-lg font-bold text-navy-900 mb-4">Archivos Adjuntos ({{ $registro->archivos->count() }})</h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @foreach($registro->archivos as $archivo)
                                <a href="{{ $archivo->url_recurso }}" target="_blank" class="flex items-center p-3 border border-gray-200 rounded-md hover:bg-gray-50 transition-colors group">
                                    <div class="bg-navy-100 p-2 rounded mr-3 text-navy-900 group-hover:bg-gold-100 group-hover:text-gold-700 transition-colors">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                    </div>
                                    <div class="overflow-hidden">
                                        <p class="text-sm font-semibold text-navy-900 truncate" title="{{ $archivo->nombre_original }}">{{ $archivo->nombre_original }}</p>
                                        <p class="text-xs text-gray-500">{{ $archivo->peso_archivo_kb }} KB</p>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Columna Secundaria: Comentarios -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-xl font-merriweather font-bold text-navy-900 mb-6 flex items-center">
                <svg class="w-5 h-5 mr-2 text-gold-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"></path></svg>
                Comentarios ({{ $registro->comentarios->count() }})
            </h3>

            <!-- Formulario de Comentarios -->
            <div class="mb-8">
                @auth
                    <form action="{{ route('comentarios.store', $registro) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <textarea name="contenido" rows="3" required placeholder="Añade tus observaciones históricas o comentarios..."
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-gold-500 focus:ring-gold-500 text-sm"></textarea>
                            @error('contenido')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <button type="submit" class="bg-navy-900 hover:bg-navy-800 text-white px-4 py-2 rounded-md text-sm font-semibold transition-colors w-full">
                            Publicar Comentario
                        </button>
                    </form>
                @else
                    <div class="bg-gray-50 border border-gray-200 rounded-md p-4 text-center">
                        <p class="text-sm text-gray-600 mb-3">Para participar en la discusión y dejar tus apuntes históricos, debes iniciar sesión.</p>
                        <div class="flex justify-center gap-3">
                            <a href="{{ route('login') }}" class="text-navy-900 font-bold hover:text-gold-600 text-sm transition-colors">Iniciar Sesión</a>
                            <span class="text-gray-300">|</span>
                            <a href="{{ route('register') }}" class="text-navy-900 font-bold hover:text-gold-600 text-sm transition-colors">Crear Cuenta</a>
                        </div>
                    </div>
                @endauth
            </div>

            <!-- Lista de Comentarios -->
            <div class="space-y-6">
                @forelse($registro->comentarios as $comentario)
                    <div class="border-b border-gray-100 pb-4 last:border-0 last:pb-0">
                        <div class="flex justify-between items-start mb-2">
                            <div class="flex items-center gap-2">
                                <span class="font-bold text-navy-900 text-sm">{{ $comentario->user->name }}</span>
                                @if($comentario->user->isAdmin())
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-navy-100 text-navy-800 uppercase">Admin</span>
                                @elseif($comentario->user->isPublicador())
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-green-100 text-green-800 uppercase">Publicador</span>
                                @endif
                            </div>
                            <span class="text-xs text-gray-400">{{ $comentario->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-sm text-gray-700">{{ $comentario->contenido }}</p>
                        
                        @auth
                            @if(Auth::user()->isAdmin() || Auth::id() === $comentario->user_id)
                                <form action="{{ route('comentarios.destroy', $comentario) }}" method="POST" class="mt-2 text-right">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs text-red-500 hover:text-red-700" onsubmit="return confirm('¿Eliminar comentario?');">Eliminar</button>
                                </form>
                            @endif
                        @endauth
                    </div>
                @empty
                    <p class="text-sm text-gray-500 text-center italic">Aún no hay comentarios en este registro histórico. Sé el primero en aportar.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
