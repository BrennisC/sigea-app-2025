@extends('layouts.app')

@section('page-title', 'Sesiones - ' . $actividad->nombre)

@section('content')
<div class="mb-6">
    <div class="flex items-center gap-2 text-sm text-gray-500 mb-2">
        <a href="{{ route('organizer.actividades.index') }}" class="hover:text-indigo-600">Mis Actividades</a>
        <span>/</span>
        <a href="{{ route('organizer.actividades.show', $actividad->id) }}" class="hover:text-indigo-600">{{ $actividad->nombre }}</a>
        <span>/</span>
        <span>Sesiones</span>
    </div>
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-semibold text-gray-900">Gestión de Sesiones</h2>
            <p class="text-gray-600">Programa y administra las sesiones de la actividad.</p>
        </div>
        <a href="{{ route('organizer.sesiones.create', $actividad->id) }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
            + Nueva Sesión
        </a>
    </div>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    @if($sesiones->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha y Hora</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sesión</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ubicación/Link</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Asistencia</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($sesiones as $sesion)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ $sesion->fecha_hora_inicio->format('d/m/Y') }}
                                </div>
                                <div class="text-xs text-gray-500">
                                    {{ $sesion->fecha_hora_inicio->format('H:i') }} - {{ $sesion->fecha_hora_fin->format('H:i') }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ $sesion->nombre }}</div>
                                @if($sesion->instructor)
                                    <div class="text-xs text-gray-500">Instr: {{ $sesion->instructor }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($sesion->ubicacion)
                                    <div class="text-sm text-gray-700">{{ $sesion->ubicacion }}</div>
                                @endif
                                @if($sesion->url_virtual)
                                    <a href="{{ $sesion->url_virtual }}" target="_blank" class="text-xs text-indigo-600 hover:text-indigo-900 underline">Link Virtual</a>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($sesion->asistencia_tomada)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Registrada
                                    </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        Pendiente
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                <a href="{{ route('organizer.asistencias.show', $sesion->id) }}" class="text-indigo-600 hover:text-indigo-900 font-bold" title="Tomar Asistencia">
                                    <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                    </svg>
                                </a>
                                <a href="{{ route('organizer.sesiones.edit', $sesion->id) }}" class="text-blue-600 hover:text-blue-900" title="Editar">
                                    <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                                <form action="{{ route('organizer.sesiones.destroy', $sesion->id) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro? Esta acción no se puede deshacer.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" title="Eliminar">
                                        <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">No hay sesiones programadas</h3>
            <p class="mt-1 text-sm text-gray-500">Comienza creando la primera sesión de clases o eventos.</p>
            <div class="mt-6">
                <a href="{{ route('organizer.sesiones.create', $actividad->id) }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                    Crear primera sesión
                </a>
            </div>
        </div>
    @endif
</div>
@endsection
