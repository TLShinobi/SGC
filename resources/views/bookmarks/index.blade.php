@extends('layouts.app')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-merriweather font-bold text-navy-900 flex items-center">
        <svg class="w-8 h-8 mr-3 text-gold-600" fill="currentColor" viewBox="0 0 20 20"><path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z"></path></svg>
        Mis Marcadores
    </h1>
    <p class="text-gray-600 mt-1">Tu colección personal de documentos preservados en la Memoria Castrense.</p>
</div>

@if($registros->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @foreach($registros as $registro)
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow group relative">
                
                <!-- Botón para quitar marcador directo en la tarjeta -->
                <div class="absolute top-2 right-2 z-10">
                    <form action="{{ route('bookmarks.toggle', $registro) }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-white/90 p-1.5 rounded-full shadow-sm text-gold-600 hover:text-red-600 transition-colors" title="Quitar de Marcadores">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z"></path></svg>
                        </button>
                    </form>
                </div>

                <div class="h-40 bg-parchment-100 flex items-center justify-center border-b border-gray-200 relative">
                    <a href="{{ route('registros.show', $registro) }}" class="absolute inset-0 z-0"></a>
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
                    <a href="{{ route('registros.show', $registro) }}">
                        <h3 class="text-lg font-merriweather font-bold text-navy-900 leading-tight mb-2 line-clamp-2 hover:text-gold-600 transition-colors" title="{{ $registro->titulo }}">{{ $registro->titulo }}</h3>
                    </a>
                    <div class="flex items-center text-sm text-gray-500 mb-3">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        {{ $registro->fecha_suceso->format('d M, Y') }}
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    
    <div class="mt-8">
        {{ $registros->links() }}
    </div>
@else
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-12 text-center mt-6">
        <svg class="w-16 h-16 text-gold-600/30 mx-auto mb-4" fill="currentColor" viewBox="0 0 20 20"><path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z"></path></svg>
        <h3 class="text-xl font-merriweather font-bold text-navy-900 mb-2">No tienes marcadores guardados</h3>
        <p class="text-gray-500 mb-6">Explora la Galería Histórica para descubrir y guardar los documentos de tu interés.</p>
        <a href="{{ route('registros.index') }}" class="inline-flex items-center bg-navy-900 hover:bg-navy-800 text-white px-6 py-3 rounded-md font-bold transition-colors">
            Ir a la Galería
        </a>
    </div>
@endif
@endsection
