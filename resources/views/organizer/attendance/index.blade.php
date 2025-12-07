@extends('layouts.app')

@section('page-title', 'Toma de Asistencia')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-semibold text-gray-900">Registro de Asistencia</h2>
    <p class="text-gray-600">Selecciona una actividad para registrar la asistencia de sus sesiones.</p>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    @if($actividades->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actividad</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Inscritos</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($actividades as $actividad)
                        <tr>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ $actividad->nombre }}</div>
                                <div class="text-xs text-gray-500">
                                    {{ $actividad->fecha_inicio->format('d/m/Y') }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $actividad->estado->nombre === 'En Curso' ? 'bg-blue-100 text-blue-800' : '' }}
                                    {{ $actividad->estado->nombre === 'Finalizada' ? 'bg-gray-100 text-gray-800' : '' }}">
                                    {{ $actividad->estado->nombre }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $actividad->inscripciones()->count() }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('organizer.sesiones.index', $actividad->id) }}" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200">
                                    Ver Sesiones
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center py-12">
            <p class="text-gray-500">No tienes actividades creadas.</p>
        </div>
    @endif
</div>
@endsection
