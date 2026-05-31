@extends('layouts.app')

@section('content')
<div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div>
        <h1 class="text-3xl font-merriweather font-bold text-navy-900">Galería Histórica</h1>
        <p class="text-gray-600 mt-1">Explora los documentos y registros preservados en el archivo.</p>
    </div>
    
    <!-- Buscador -->
    <form action="{{ route('registros.index') }}" method="GET" class="flex w-full md:w-auto gap-2">
        <input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="Buscar en el archivo..." 
               class="w-full md:w-80 rounded-md border-gray-300 shadow-sm focus:border-gold-500 focus:ring-gold-500 text-sm">
        <button type="submit" class="bg-navy-900 hover:bg-navy-800 text-white px-4 py-2 rounded-md text-sm font-semibold transition-colors">
            Buscar
        </button>
    </form>
</div>

<!-- Grid de Resultados -->
@if($registros->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @foreach($registros as $registro)
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow group">
                <div class="h-40 bg-parchment-100 flex items-center justify-center border-b border-gray-200">
                    @if(Str::startsWith($registro->tipo_archivo, 'image/'))
                        <div class="w-full h-full bg-cover bg-center" style="background-image: url('{{ $registro->url_recurso }}');"></div>
                    @elseif($registro->tipo_archivo === 'application/pdf')
                        <svg class="w-16 h-16 text-red-700 opacity-80 group-hover:scale-110 transition-transform" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14H9V8h2v8zm5 0h-2V8h2v8z"/></svg>
                    @else
                        <svg class="w-16 h-16 text-gray-400 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                    @endif
                </div>
                <div class="p-4">
                    <div class="text-xs text-gold-600 font-bold uppercase tracking-wider mb-1">{{ $registro->categoria->nombre ?? 'Sin Clasificar' }}</div>
                    <h3 class="text-lg font-merriweather font-bold text-navy-900 leading-tight mb-2 line-clamp-2" title="{{ $registro->titulo }}">{{ $registro->titulo }}</h3>
                    <div class="flex items-center text-sm text-gray-500 mb-3">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        {{ $registro->fecha_suceso->format('d M, Y') }}
                    </div>
                    <p class="text-sm text-gray-600 line-clamp-3 mb-4" title="{{ $registro->descripcion }}">{{ $registro->descripcion }}</p>
                    
                    <div class="flex justify-between items-center mt-auto pt-4 border-t border-gray-100">
                        <a href="{{ route('registros.show', $registro) }}" class="text-navy-900 hover:text-gold-600 text-sm font-semibold flex items-center transition-colors">
                            Ver Detalles
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                        
                        @auth
                            @if(Auth::user()->isAdmin())
                                <form action="{{ route('registros.destroy', $registro) }}" method="POST" onsubmit="return confirm('¿Archivar este registro histórico?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm transition-colors">Archivar</button>
                                </form>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    
    <div class="mt-8">
        {{ $registros->links() }}
    </div>
@else
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-12 text-center">
        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
        <h3 class="text-xl font-merriweather font-bold text-navy-900 mb-2">El Archivo está vacío</h3>
        <p class="text-gray-500 mb-6">No hay registros históricos que coincidan con tu búsqueda o aún no se ha preservado ningún documento.</p>
        <a href="{{ route('registros.create') }}" class="inline-flex items-center bg-gold-600 hover:bg-gold-500 text-navy-950 px-6 py-3 rounded-md font-bold transition-colors">
            Preservar Primer Documento
        </a>
    </div>
@endif

@endsection
