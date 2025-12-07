@extends('layouts.app')

@section('page-title', 'Editar Actividad')

@section('content')
<div class="mb-6">
    <div class="flex items-center gap-2 text-sm text-gray-500 mb-2">
        <a href="{{ route('organizer.actividades.index') }}" class="hover:text-indigo-600">Mis Actividades</a>
        <span>/</span>
        <a href="{{ route('organizer.actividades.show', $actividad->id) }}" class="hover:text-indigo-600">{{ $actividad->nombre }}</a>
        <span>/</span>
        <span>Editar</span>
    </div>
    <h2 class="text-2xl font-semibold text-gray-900">Editar Actividad</h2>
</div>

<div class="bg-white rounded-lg shadow p-6 max-w-3xl">
    <form action="{{ route('organizer.actividades.update', $actividad->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 gap-6">
            <!-- Nombre -->
            <div>
                <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre de la Actividad</label>
                <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $actividad->nombre) }}" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
            </div>

            <!-- Tipo y Estado -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="tipo_id" class="block text-sm font-medium text-gray-700">Tipo de Actividad</label>
                    <select name="tipo_id" id="tipo_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                        @foreach($tipos as $tipo)
                            <option value="{{ $tipo->id }}" {{ old('tipo_id', $actividad->tipo_id) == $tipo->id ? 'selected' : '' }}>
                                {{ $tipo->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="estado_id" class="block text-sm font-medium text-gray-700">Estado</label>
                    <select name="estado_id" id="estado_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                        @foreach($estados as $estado)
                            <option value="{{ $estado->id }}" {{ old('estado_id', $actividad->estado_id) == $estado->id ? 'selected' : '' }}>
                                {{ $estado->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Modalidad -->
            <div>
                <label for="modalidad" class="block text-sm font-medium text-gray-700">Modalidad</label>
                <select name="modalidad" id="modalidad" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                    @foreach($modalidades as $modalidad)
                        <option value="{{ $modalidad }}" {{ old('modalidad', $actividad->modalidad) == $modalidad ? 'selected' : '' }}>
                            {{ ucfirst($modalidad) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Fechas -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="fecha_inicio" class="block text-sm font-medium text-gray-700">Fecha Inicio</label>
                    <input type="datetime-local" name="fecha_inicio" id="fecha_inicio" value="{{ old('fecha_inicio', $actividad->fecha_inicio->format('Y-m-d\TH:i')) }}" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                </div>

                <div>
                    <label for="fecha_fin" class="block text-sm font-medium text-gray-700">Fecha Fin</label>
                    <input type="datetime-local" name="fecha_fin" id="fecha_fin" value="{{ old('fecha_fin', $actividad->fecha_fin->format('Y-m-d\TH:i')) }}" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                </div>
            </div>

            <!-- Ubicacion y URL -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="ubicacion" class="block text-sm font-medium text-gray-700">Ubicación (Presencial)</label>
                    <input type="text" name="ubicacion" id="ubicacion" value="{{ old('ubicacion', $actividad->ubicacion) }}" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>

                <div>
                    <label for="url_virtual" class="block text-sm font-medium text-gray-700">URL (Virtual)</label>
                    <input type="url" name="url_virtual" id="url_virtual" value="{{ old('url_virtual', $actividad->url_virtual) }}" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>
            </div>

            <!-- Precio y Cupo -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label for="precio" class="block text-sm font-medium text-gray-700">Precio (0 para gratis)</label>
                    <input type="number" step="0.01" name="precio" id="precio" value="{{ old('precio', $actividad->precio) }}" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                </div>

                <div>
                    <label for="cupo_maximo" class="block text-sm font-medium text-gray-700">Cupo Máximo</label>
                    <input type="number" name="cupo_maximo" id="cupo_maximo" value="{{ old('cupo_maximo', $actividad->cupo_maximo) }}" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>
                
                 <div>
                    <label for="horas_totales" class="block text-sm font-medium text-gray-700">Horas Totales</label>
                    <input type="number" name="horas_totales" id="horas_totales" value="{{ old('horas_totales', $actividad->horas_totales) }}" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>
            </div>
            
            <!-- Descripcion -->
            <div>
                <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción</label>
                <textarea name="descripcion" id="descripcion" rows="4" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('descripcion', $actividad->descripcion) }}</textarea>
            </div>
            
            <!-- Imagen URL -->
            <div>
                 <label for="imagen_url" class="block text-sm font-medium text-gray-700">URL Imagen Banner</label>
                 <input type="url" name="imagen_url" id="imagen_url" value="{{ old('imagen_url', $actividad->imagen_url) }}"
                     class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>

            <div class="flex justify-end pt-5">
                <a href="{{ route('organizer.actividades.show', $actividad->id) }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mr-3">
                    Cancelar
                </a>
                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Actualizar Actividad
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
