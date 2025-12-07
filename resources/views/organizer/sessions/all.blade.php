@extends('layouts.app')

@section('page-title', 'Gestión de Sesiones')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-semibold text-gray-900">Gestión de Sesiones</h2>
    <p class="text-gray-600">Selecciona una actividad para programar y administrar sus sesiones.</p>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    @if($actividades->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actividad</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fechas</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sesiones</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($actividades as $actividad)
                        <tr>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ $actividad->nombre }}</div>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $actividad->estado->nombre === 'Publicada' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $actividad->estado->nombre === 'Finalizada' ? 'bg-gray-100 text-gray-800' : '' }}">
                                    {{ $actividad->estado->nombre }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $actividad->fecha_inicio->format('d/m/Y') }} - {{ $actividad->fecha_fin->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $actividad->sesiones()->count() }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('organizer.sesiones.index', $actividad->id) }}" class="text-indigo-600 hover:text-indigo-900 font-semibold">
                                    Gestionar Sesiones &rarr;
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
