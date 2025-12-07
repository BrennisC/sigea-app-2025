@extends('layouts.app')

@section('page-title', 'Mis Actividades')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-semibold text-gray-900">Mis Actividades Inscritas</h2>
    <p class="text-gray-600">Gestina tus inscripciones y revisa el estado de tus actividades.</p>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    @if($inscripciones->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actividad</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Modalidad</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado Inscripción</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($inscripciones as $inscripcion)
                        <tr>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ $inscripcion->actividad->nombre }}</div>
                                <div class="text-sm text-gray-500">{{ Str::limit($inscripcion->actividad->descripcion, 50) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $inscripcion->actividad->fecha_inicio->format('d/m/Y') }}</div>
                                <div class="text-sm text-gray-500">{{ $inscripcion->actividad->fecha_inicio->format('H:i') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                    {{ ucfirst($inscripcion->actividad->modalidad) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $inscripcion->estado->nombre === 'Confirmada' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $inscripcion->estado->nombre === 'Pendiente' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $inscripcion->estado->nombre === 'Cancelada' ? 'bg-red-100 text-red-800' : '' }}">
                                    {{ $inscripcion->estado->nombre ?? 'Pendiente' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="#" class="text-indigo-600 hover:text-indigo-900">Ver Detalles</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $inscripciones->links() }}
        </div>
    @else
        <div class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">No tienes inscripciones</h3>
            <p class="mt-1 text-sm text-gray-500">Inscríbete en actividades para verlas aquí.</p>
            <div class="mt-6">
                <a href="{{ route('actividades.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                    Ver Actividades Disponibles
                </a>
            </div>
        </div>
    @endif
</div>
@endsection
