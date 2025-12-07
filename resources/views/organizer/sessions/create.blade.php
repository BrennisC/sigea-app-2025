@extends('layouts.app')

@section('page-title', 'Nueva Sesión')

@section('content')
<div class="mb-6">
    <div class="flex items-center gap-2 text-sm text-gray-500 mb-2">
        <a href="{{ route('organizer.actividades.index') }}" class="hover:text-indigo-600">Mis Actividades</a>
        <span>/</span>
        <a href="{{ route('organizer.actividades.show', $actividad->id) }}" class="hover:text-indigo-600">{{ $actividad->nombre }}</a>
        <span>/</span>
        <a href="{{ route('organizer.sesiones.index', $actividad->id) }}" class="hover:text-indigo-600">Sesiones</a>
        <span>/</span>
        <span>Nueva</span>
    </div>
    <h2 class="text-2xl font-semibold text-gray-900">Programar Nueva Sesión</h2>
</div>

<div class="bg-white rounded-lg shadow p-6 max-w-3xl">
    <form action="{{ route('organizer.sesiones.store', $actividad->id) }}" method="POST">
        @csrf
        
        <div class="grid grid-cols-1 gap-6">
            <!-- Nombre -->
            <div>
                <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre de la Sesión</label>
                <input type="text" name="nombre" id="nombre" value="{{ old('nombre', 'Sesión ' . ($actividad->sesiones()->count() + 1)) }}" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
            </div>

            <!-- Instructor -->
            <div>
                <label for="instructor" class="block text-sm font-medium text-gray-700">Instructor / Facilitador (Opcional)</label>
                <input type="text" name="instructor" id="instructor" value="{{ old('instructor') }}" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>

            <!-- Fechas -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="fecha_hora_inicio" class="block text-sm font-medium text-gray-700">Fecha y Hora Inicio</label>
                    <input type="datetime-local" name="fecha_hora_inicio" id="fecha_hora_inicio" value="{{ old('fecha_hora_inicio') }}" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                </div>

                <div>
                    <label for="fecha_hora_fin" class="block text-sm font-medium text-gray-700">Fecha y Hora Fin</label>
                    <input type="datetime-local" name="fecha_hora_fin" id="fecha_hora_fin" value="{{ old('fecha_hora_fin') }}" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                </div>
            </div>

            <!-- Duracion (Calculated or Manual) -->
            <div>
                <label for="duracion_minutos" class="block text-sm font-medium text-gray-700">Duración (minutos)</label>
                <input type="number" name="duracion_minutos" id="duracion_minutos" value="{{ old('duracion_minutos') }}" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                <p class="text-xs text-gray-500 mt-1">Si se deja vacío, se calculará automáticamente basado en las fechas.</p>
            </div>

            <!-- Ubicacion -->
            <div>
                <label for="ubicacion" class="block text-sm font-medium text-gray-700">Ubicación Física (Aula, Auditorio, etc.)</label>
                <input type="text" name="ubicacion" id="ubicacion" value="{{ old('ubicacion', $actividad->ubicacion) }}" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>

            <!-- URL Virtual -->
            <div>
                <label for="url_virtual" class="block text-sm font-medium text-gray-700">Enlace Virtual (Zoom, Meet, etc.)</label>
                <input type="url" name="url_virtual" id="url_virtual" value="{{ old('url_virtual') }}" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="https://meet.google.com/...">
            </div>

            <!-- Descripcion -->
            <div>
                <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción / Notas</label>
                <textarea name="descripcion" id="descripcion" rows="3" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('descripcion') }}</textarea>
            </div>

            <div class="flex justify-end pt-5">
                <a href="{{ route('organizer.sesiones.index', $actividad->id) }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mr-3">
                    Cancelar
                </a>
                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Guardar Sesión
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
