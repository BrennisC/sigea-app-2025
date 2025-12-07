@extends('layouts.app')

@section('page-title', 'Nueva Actividad')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('organizer.actividades.index') }}" class="text-indigo-600 hover:text-indigo-800">
            ← Volver a mis actividades
        </a>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-2xl font-semibold mb-6">Crear Nueva Actividad</h2>

        <form method="POST" action="{{ route('organizer.actividades.store') }}">
            @csrf

            <!-- Información Básica -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold mb-4 text-gray-700">Información Básica</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nombre de la Actividad *</label>
                        <input type="text" name="nombre" value="{{ old('nombre') }}" required 
                            class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500">
                        @error('nombre')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Descripción *</label>
                        <textarea name="descripcion" rows="4" required 
                            class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500">{{ old('descripcion') }}</textarea>
                        @error('descripcion')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tipo *</label>
                        <select name="tipo_id" required class="w-full border border-gray-300 rounded-md px-4 py-2">
                            <option value="">Seleccionar tipo</option>
                            @foreach($tipos as $tipo)
                                <option value="{{ $tipo->id }}" {{ old('tipo_id') == $tipo->id ? 'selected' : '' }}>
                                    {{ $tipo->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('tipo_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Estado *</label>
                        <select name="estado_id" required class="w-full border border-gray-300 rounded-md px-4 py-2">
                            <option value="">Seleccionar estado</option>
                            @foreach($estados as $estado)
                                <option value="{{ $estado->id }}" {{ old('estado_id') == $estado->id ? 'selected' : '' }}>
                                    {{ $estado->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('estado_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Fechas y Duración -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold mb-4 text-gray-700">Fechas y Duración</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Fecha de Inicio *</label>
                        <input type="date" name="fecha_inicio" value="{{ old('fecha_inicio') }}" required 
                            class="w-full border border-gray-300 rounded-md px-4 py-2">
                        @error('fecha_inicio')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Fecha de Fin *</label>
                        <input type="date" name="fecha_fin" value="{{ old('fecha_fin') }}" required 
                            class="w-full border border-gray-300 rounded-md px-4 py-2">
                        @error('fecha_fin')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Horas Totales</label>
                        <input type="number" name="horas_totales" value="{{ old('horas_totales') }}" min="1" 
                            class="w-full border border-gray-300 rounded-md px-4 py-2">
                        @error('horas_totales')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">% Asistencia Mínima para Certificado</label>
                        <input type="number" name="porcentaje_asistencia_minima" value="{{ old('porcentaje_asistencia_minima', 75) }}" 
                            min="0" max="100" step="0.01" class="w-full border border-gray-300 rounded-md px-4 py-2">
                        @error('porcentaje_asistencia_minima')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Modalidad y Ubicación -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold mb-4 text-gray-700">Modalidad y Ubicación</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Modalidad *</label>
                        <select name="modalidad" required class="w-full border border-gray-300 rounded-md px-4 py-2" id="modalidad">
                            <option value="">Seleccionar modalidad</option>
                            <option value="presencial" {{ old('modalidad') == 'presencial' ? 'selected' : '' }}>Presencial</option>
                            <option value="virtual" {{ old('modalidad') == 'virtual' ? 'selected' : '' }}>Virtual</option>
                            <option value="hibrida" {{ old('modalidad') == 'hibrida' ? 'selected' : '' }}>Híbrida</option>
                        </select>
                        @error('modalidad')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Cupo Máximo</label>
                        <input type="number" name="cupo_maximo" value="{{ old('cupo_maximo') }}" min="1" 
                            class="w-full border border-gray-300 rounded-md px-4 py-2">
                        @error('cupo_maximo')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div id="ubicacion-field">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Ubicación</label>
                        <input type="text" name="ubicacion" value="{{ old('ubicacion') }}" 
                            class="w-full border border-gray-300 rounded-md px-4 py-2" placeholder="Dirección o lugar">
                        @error('ubicacion')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div id="url-field">
                        <label class="block text-sm font-medium text-gray-700 mb-2">URL Virtual</label>
                        <input type="url" name="url_virtual" value="{{ old('url_virtual') }}" 
                            class="w-full border border-gray-300 rounded-md px-4 py-2" placeholder="https://zoom.us/...">
                        @error('url_virtual')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Pago -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold mb-4 text-gray-700">Información de Pago</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="flex items-center">
                            <input type="checkbox" name="requiere_pago" value="1" {{ old('requiere_pago') ? 'checked' : '' }} 
                                class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" id="requiere_pago">
                            <span class="ml-2 text-sm text-gray-700">¿Requiere pago?</span>
                        </label>
                    </div>

                    <div id="precio-field">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Precio</label>
                        <input type="number" name="precio" value="{{ old('precio', 0) }}" min="0" step="0.01" 
                            class="w-full border border-gray-300 rounded-md px-4 py-2">
                        @error('precio')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Botones -->
            <div class="flex justify-end space-x-4">
                <a href="{{ route('organizer.actividades.index') }}" class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                    Cancelar
                </a>
                <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                    Crear Actividad
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Mostrar/ocultar campos según modalidad
    document.getElementById('modalidad').addEventListener('change', function() {
        const ubicacion = document.getElementById('ubicacion-field');
        const url = document.getElementById('url-field');
        
        if (this.value === 'presencial') {
            ubicacion.style.display = 'block';
            url.style.display = 'none';
        } else if (this.value === 'virtual') {
            ubicacion.style.display = 'none';
            url.style.display = 'block';
        } else if (this.value === 'hibrida') {
            ubicacion.style.display = 'block';
            url.style.display = 'block';
        }
    });

    // Habilitar/deshabilitar campo precio
    document.getElementById('requiere_pago').addEventListener('change', function() {
        const precioField = document.querySelector('input[name="precio"]');
        precioField.disabled = !this.checked;
        if (!this.checked) {
            precioField.value = 0;
        }
    });
</script>
@endsection
