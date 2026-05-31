@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-8">
        <a href="{{ route('registros.index') }}" class="text-navy-900 hover:text-gold-600 font-medium text-sm flex items-center mb-4 transition-colors">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Volver a la Galería
        </a>
        <h1 class="text-3xl font-merriweather font-bold text-navy-900">Ingesta de Patrimonio Histórico</h1>
        <p class="text-gray-600 mt-2">Complete el formulario con el máximo rigor histórico para preservar el documento en el archivo digital.</p>
    </div>

    <form action="{{ route('registros.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        @csrf
        
        <div class="p-6 md:p-8">
            <!-- Errores de Validación -->
            @if ($errors->any())
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-md">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">Se encontraron errores en la ingesta:</h3>
                            <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Columna Izquierda: Metadatos -->
                <div class="space-y-6">
                    <div>
                        <label for="titulo" class="block text-sm font-bold text-navy-900 mb-1">Título del Recurso *</label>
                        <input type="text" name="titulo" id="titulo" value="{{ old('titulo') }}" required
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-gold-500 focus:ring-gold-500 sm:text-sm"
                            placeholder="Ej. Tratado de Armisticio original">
                    </div>

                    <div>
                        <label for="id_categoria" class="block text-sm font-bold text-navy-900 mb-1">Clasificación *</label>
                        <select name="id_categoria" id="id_categoria" required
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-gold-500 focus:ring-gold-500 sm:text-sm">
                            <option value="">Seleccione una categoría...</option>
                            @foreach($categorias as $categoria)
                                <option value="{{ $categoria->id }}" {{ old('id_categoria') == $categoria->id ? 'selected' : '' }}>
                                    {{ $categoria->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="fecha_suceso" class="block text-sm font-bold text-navy-900 mb-1">Fecha del Suceso/Documento *</label>
                        <input type="date" name="fecha_suceso" id="fecha_suceso" value="{{ old('fecha_suceso') }}" required
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-gold-500 focus:ring-gold-500 sm:text-sm">
                    </div>

                    <div>
                        <label for="descripcion" class="block text-sm font-bold text-navy-900 mb-1">Contexto Histórico (Descripción) *</label>
                        <textarea name="descripcion" id="descripcion" rows="5" required
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-gold-500 focus:ring-gold-500 sm:text-sm"
                            placeholder="Describa el origen, importancia y contexto de este documento para la memoria castrense...">{{ old('descripcion') }}</textarea>
                    </div>
                </div>

                <!-- Columna Derecha: Archivo Multimedia -->
                <div>
                    <label class="block text-sm font-bold text-navy-900 mb-2">Archivo Físico Digitalizado *</label>
                    
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:bg-gray-50 transition-colors cursor-pointer group" onclick="document.getElementById('archivo').click()">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400 group-hover:text-gold-500 transition-colors" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600 justify-center">
                                <span class="relative cursor-pointer bg-white rounded-md font-medium text-navy-900 hover:text-gold-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-gold-500">
                                    <span>Subir un archivo</span>
                                    <input id="archivo" name="archivo" type="file" class="sr-only" required accept=".pdf,.jpg,.jpeg,.png">
                                </span>
                                <p class="pl-1">o arrastrar y soltar</p>
                            </div>
                            <p class="text-xs text-gray-500">PDF, PNG, JPG hasta 10MB</p>
                        </div>
                    </div>
                    <p id="file-name-display" class="mt-2 text-sm text-navy-800 font-semibold hidden">Archivo seleccionado: <span></span></p>

                    <div class="mt-6 bg-blue-50 border-l-4 border-blue-400 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3 flex-1 md:flex md:justify-between">
                                <p class="text-xs text-blue-700">
                                    Al preservar este documento, será enviado al Storage seguro de Supabase. Asegúrese de que el documento no exceda la clasificación de seguridad permitida.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex items-center justify-end">
            <button type="submit" class="bg-gold-600 hover:bg-gold-500 text-navy-950 px-6 py-2 rounded-md font-bold shadow-sm transition-colors flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                Preservar Documento Histórico
            </button>
        </div>
    </form>
</div>

<!-- Script para mostrar nombre del archivo -->
<script>
    document.getElementById('archivo').addEventListener('change', function(e) {
        var fileName = e.target.files[0].name;
        var display = document.getElementById('file-name-display');
        display.querySelector('span').textContent = fileName;
        display.classList.remove('hidden');
    });
</script>
@endsection
