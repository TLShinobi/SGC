@extends('layouts.app')

@section('content')

<!-- SECCIÓN: HERO / EFEMÉRIDES -->
<div class="mb-12">
    @if($efemerides->count() > 0)
        <div class="bg-navy-900 rounded-xl shadow-lg overflow-hidden border border-gold-600/30">
            <div class="p-8 md:p-12 text-center border-b border-navy-800">
                <p class="text-gold-500 font-bold tracking-widest uppercase text-sm mb-2">Tal día como hoy en la historia...</p>
                <h1 class="text-3xl md:text-5xl font-merriweather font-bold text-white mb-4">Efemérides del {{ now()->format('d \d\e M') }}</h1>
                <p class="text-gray-300 max-w-2xl mx-auto">Conmemoramos y recordamos los sucesos trascendentales que marcaron nuestra memoria institucional en esta misma fecha.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-0 divide-y md:divide-y-0 md:divide-x divide-navy-800">
                @foreach($efemerides as $efemeride)
                    <div class="p-8 flex flex-col items-center text-center hover:bg-navy-800/50 transition-colors">
                        @if(Str::startsWith($efemeride->tipo_archivo, 'image/'))
                            <div class="w-32 h-32 rounded-full border-4 border-gold-600/50 mb-6 bg-cover bg-center shadow-inner" style="background-image: url('{{ $efemeride->url_recurso }}');"></div>
                        @else
                            <div class="w-32 h-32 rounded-full border-4 border-gold-600/50 mb-6 flex items-center justify-center bg-navy-800 text-gold-500 shadow-inner">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            </div>
                        @endif
                        <h3 class="text-xl font-merriweather font-bold text-white mb-2">{{ $efemeride->titulo }}</h3>
                        <p class="text-gray-400 text-sm mb-4 line-clamp-3">{{ $efemeride->descripcion }}</p>
                        <a href="{{ route('registros.show', $efemeride) }}" class="mt-auto text-gold-500 hover:text-gold-400 font-bold text-sm uppercase tracking-wider inline-flex items-center">
                            Explorar Suceso <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <div class="bg-navy-900 rounded-xl shadow-lg overflow-hidden border border-gold-600/30 relative">
            <div class="absolute inset-0 bg-cover bg-center opacity-20" style="background-image: url('https://www.transparenttextures.com/patterns/aged-paper.png');"></div>
            <div class="relative z-10 p-12 md:p-20 text-center">
                <svg class="w-16 h-16 text-gold-500 mx-auto mb-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1.323l3.954 1.582 1.599-.8a1 1 0 01.894 1.79l-1.233.616 1.738 5.42a1 1 0 01-.285 1.05A3.989 3.989 0 0115 15a3.989 3.989 0 01-2.667-1.019 1 1 0 01-.285-1.05l1.715-5.349L11 6.477V16h2a1 1 0 110 2H7a1 1 0 110-2h2V6.477L6.237 7.582l1.715 5.349a1 1 0 01-.285 1.05A3.989 3.989 0 015 15a3.989 3.989 0 01-2.667-1.019 1 1 0 01-.285-1.05l1.738-5.42-1.233-.617a1 1 0 01.894-1.788l1.599.799L9 4.323V3a1 1 0 011-1zm-5 8.274l-.818 2.552c.25.112.526.174.818.174.292 0 .569-.062.818-.174L5 10.274zm10 0l-.818 2.552c.25.112.526.174.818.174.292 0 .569-.062.818-.174L15 10.274z" clip-rule="evenodd" /></svg>
                <h1 class="text-4xl md:text-5xl font-merriweather font-bold text-white mb-4">Portal de la Memoria Castrense</h1>
                <p class="text-gray-300 max-w-2xl mx-auto mb-8 text-lg">Preservando el patrimonio histórico, táctico y humano de nuestra institución para las futuras generaciones.</p>
                <a href="{{ route('registros.index') }}" class="inline-flex items-center bg-gold-600 hover:bg-gold-500 text-navy-950 px-8 py-3 rounded-md font-bold transition-colors shadow-lg">
                    Explorar el Archivo Completo
                </a>
            </div>
        </div>
    @endif
</div>

<!-- SECCIÓN: RELEVANTES -->
@if($relevantes->count() > 0)
<div class="mb-16">
    <div class="flex items-center justify-between mb-6 border-b border-gray-200 pb-2">
        <h2 class="text-2xl font-merriweather font-bold text-navy-900 flex items-center">
            <svg class="w-6 h-6 mr-2 text-gold-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
            Documentos Relevantes
        </h2>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach($relevantes as $registro)
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-all hover:-translate-y-1">
                <div class="h-32 bg-parchment-100 border-b border-gray-200 flex justify-center items-center relative">
                    <span class="absolute top-2 right-2 bg-navy-900/80 text-white text-[10px] font-bold px-2 py-1 rounded backdrop-blur-sm flex items-center">
                        <svg class="w-3 h-3 mr-1 text-gold-500" fill="currentColor" viewBox="0 0 20 20"><path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z"></path></svg>
                        {{ $registro->marcados_por_count }}
                    </span>
                    @if(Str::startsWith($registro->tipo_archivo, 'image/'))
                        <div class="w-full h-full bg-cover bg-center" style="background-image: url('{{ $registro->url_recurso }}');"></div>
                    @else
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                    @endif
                </div>
                <div class="p-4">
                    <div class="text-[10px] text-gold-600 font-bold uppercase tracking-wider mb-1">{{ $registro->categoria->nombre }}</div>
                    <a href="{{ route('registros.show', $registro) }}">
                        <h3 class="text-base font-merriweather font-bold text-navy-900 leading-tight mb-2 line-clamp-2 hover:text-gold-600 transition-colors">{{ $registro->titulo }}</h3>
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endif

<!-- SECCIÓN: RECIENTES -->
<div class="mb-12">
    <div class="flex items-center justify-between mb-6 border-b border-gray-200 pb-2">
        <h2 class="text-2xl font-merriweather font-bold text-navy-900 flex items-center">
            <svg class="w-6 h-6 mr-2 text-gold-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            Ingresos Recientes
        </h2>
        <a href="{{ route('registros.index') }}" class="text-sm font-bold text-navy-900 hover:text-gold-600 transition-colors flex items-center">
            Ver Todos <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
        </a>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @foreach($recientes as $registro)
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow flex flex-row">
                <div class="w-1/3 bg-parchment-100 flex-shrink-0 flex items-center justify-center border-r border-gray-200">
                    @if(Str::startsWith($registro->tipo_archivo, 'image/'))
                        <div class="w-full h-full bg-cover bg-center" style="background-image: url('{{ $registro->url_recurso }}');"></div>
                    @else
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                    @endif
                </div>
                <div class="p-4 flex flex-col justify-between w-2/3">
                    <div>
                        <div class="text-[10px] text-gold-600 font-bold uppercase tracking-wider mb-1">{{ $registro->categoria->nombre }}</div>
                        <a href="{{ route('registros.show', $registro) }}">
                            <h3 class="text-sm md:text-base font-merriweather font-bold text-navy-900 leading-tight mb-2 line-clamp-2 hover:text-gold-600 transition-colors">{{ $registro->titulo }}</h3>
                        </a>
                        <p class="text-xs text-gray-500 mb-2">{{ $registro->fecha_suceso->format('d/m/Y') }}</p>
                    </div>
                    <a href="{{ route('registros.show', $registro) }}" class="text-xs font-bold text-navy-900 hover:text-gold-600 transition-colors">Ver Detalles &rarr;</a>
                </div>
            </div>
        @endforeach
    </div>
</div>

@endsection
