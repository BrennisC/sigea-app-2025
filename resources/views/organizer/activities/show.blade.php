@extends('layouts.app')

@section('page-title', $actividad->nombre)

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div class="flex items-center gap-2 text-sm text-gray-500">
        <a href="{{ route('organizer.actividades.index') }}" class="hover:text-indigo-600">Mis Actividades</a>
        <span>/</span>
        <span>Detalles</span>
    </div>
    <div class="space-x-2">
        <a href="{{ route('organizer.actividades.edit', $actividad->id) }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
            Editar Actividad
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Main Info -->
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex justify-between items-start mb-4">
                <h2 class="text-2xl font-bold text-gray-900">{{ $actividad->nombre }}</h2>
                <span class="px-3 py-1 text-xs font-semibold rounded-full 
                    {{ $actividad->estado->nombre === 'Publicada' ? 'bg-green-100 text-green-800' : '' }}
                    {{ $actividad->estado->nombre === 'Planificada' ? 'bg-yellow-100 text-yellow-800' : '' }}
                    {{ $actividad->estado->nombre === 'En Curso' ? 'bg-blue-100 text-blue-800' : '' }}
                    {{ $actividad->estado->nombre === 'Finalizada' ? 'bg-gray-100 text-gray-800' : '' }}">
                    {{ $actividad->estado->nombre }}
                </span>
            </div>
            
            <p class="text-gray-600 mb-6">{{ $actividad->descripcion }}</p>

            <div class="grid grid-cols-2 gap-4 text-sm text-gray-500 border-t pt-4">
                <div>
                    <span class="block font-medium text-gray-700">Tipo:</span>
                    {{ $actividad->tipo->nombre }}
                </div>
                <div>
                    <span class="block font-medium text-gray-700">Modalidad:</span>
                    {{ ucfirst($actividad->modalidad) }}
                </div>
                <div>
                    <span class="block font-medium text-gray-700">Fechas:</span>
                    {{ $actividad->fecha_inicio->format('d/m/Y') }} - {{ $actividad->fecha_fin->format('d/m/Y') }}
                </div>
                <div>
                    <span class="block font-medium text-gray-700">Ubicación:</span>
                    {{ $actividad->ubicacion ?? 'N/A' }}
                </div>
            </div>
        </div>

        <!-- Management Links -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Gestión</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <a href="{{ route('organizer.sesiones.index', $actividad->id) }}" class="flex items-center justify-center p-4 border rounded-lg hover:bg-gray-50 transition border-l-4 border-l-green-500">
                    <div class="text-center">
                        <span class="block text-xl font-bold text-gray-900">{{ $actividad->sesiones->count() }}</span>
                        <span class="text-sm text-gray-600">Sesiones</span>
                    </div>
                </a>

                <a href="{{ route('organizer.actividades.enrollments', $actividad->id) }}" class="flex items-center justify-center p-4 border rounded-lg hover:bg-gray-50 transition border-l-4 border-l-purple-500">
                    <div class="text-center">
                        <span class="block text-xl font-bold text-gray-900">{{ $actividad->inscripciones->count() }}</span>
                        <span class="text-sm text-gray-600">Inscritos</span>
                    </div>
                </a>

                <a href="{{ route('organizer.certificados.index', $actividad->id) }}" class="flex items-center justify-center p-4 border rounded-lg hover:bg-gray-50 transition border-l-4 border-l-yellow-500">
                    <div class="text-center">
                        <!-- We might not have certificate count eager loaded easily here unless passed, but links is key -->
                         <svg class="h-6 w-6 text-yellow-600 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <span class="text-sm text-gray-600">Certificados</span>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <!-- Sidebar Info -->
    <div class="space-y-6">
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Detalles Adicionales</h3>
            <ul class="space-y-3 text-sm">
                <li class="flex justify-between">
                    <span class="text-gray-500">Precio:</span>
                    <span class="font-medium text-gray-900">${{ number_format($actividad->precio, 2) }}</span>
                </li>
                <li class="flex justify-between">
                    <span class="text-gray-500">Cupo Máximo:</span>
                    <span class="font-medium text-gray-900">{{ $actividad->cupo_maximo ?? 'Ilimitado' }}</span>
                </li>
                <li class="flex justify-between">
                    <span class="text-gray-500">Horas Totales:</span>
                    <span class="font-medium text-gray-900">{{ $actividad->horas_totales }}h</span>
                </li>
                <li class="flex justify-between">
                    <span class="text-gray-500">Asistencia Min.:</span>
                    <span class="font-medium text-gray-900">{{ $actividad->porcentaje_asistencia_minima }}%</span>
                </li>
            </ul>
        </div>
    </div>
</div>
@endsection
