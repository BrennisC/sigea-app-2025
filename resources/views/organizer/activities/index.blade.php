@extends('layouts.app')

@section('page-title', 'Mis Actividades')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h2 class="text-2xl font-semibold">Mis Actividades</h2>
    <a href="{{ route('organizer.actividades.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
        + Nueva Actividad
    </a>
</div>

<div class="bg-white rounded-lg shadow">
    <div class="p-6">
        @if($actividades->count() > 0)
            <div class="space-y-4">
                @foreach($actividades as $actividad)
                    <div class="border rounded-lg p-4 hover:shadow-md transition">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <div class="flex items-center space-x-3 mb-2">
                                    <h3 class="text-lg font-semibold">{{ $actividad->nombre }}</h3>
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full 
                                        {{ $actividad->estado->nombre === 'Publicada' ? 'bg-green-100 text-green-800' : '' }}
                                        {{ $actividad->estado->nombre === 'Planificada' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                        {{ $actividad->estado->nombre === 'En Curso' ? 'bg-blue-100 text-blue-800' : '' }}
                                        {{ $actividad->estado->nombre === 'Finalizada' ? 'bg-gray-100 text-gray-800' : '' }}">
                                        {{ $actividad->estado->nombre ?? 'Sin estado' }}
                                    </span>
                                </div>
                                <p class="text-sm text-gray-600 mb-3">{{ Str::limit($actividad->descripcion, 150) }}</p>
                                <div class="flex items-center space-x-6 text-sm text-gray-500">
                                    <span>📅 {{ $actividad->fecha_inicio->format('d/m/Y') }} - {{ $actividad->fecha_fin->format('d/m/Y') }}</span>
                                    <span>{{ $actividad->tipo->nombre ?? 'N/A' }}</span>
                                    <span>{{ ucfirst($actividad->modalidad) }}</span>
                                    <span>👥 {{ $actividad->inscripciones->count() }} inscritos</span>
                                    @if($actividad->cupo_maximo)
                                        <span>/ {{ $actividad->cupo_maximo }} cupos</span>
                                    @endif
                                </div>
                            </div>
                            <div class="flex flex-col space-y-2 ml-4">
                                <a href="{{ route('organizer.actividades.show', $actividad->id) }}" class="text-indigo-600 hover:text-indigo-800 text-sm">
                                    Ver Detalle
                                </a>
                                <a href="{{ route('organizer.actividades.edit', $actividad->id) }}" class="text-blue-600 hover:text-blue-800 text-sm">
                                    Editar
                                </a>
                                <a href="{{ route('organizer.sesiones.index', $actividad->id) }}" class="text-green-600 hover:text-green-800 text-sm">
                                    Sesiones ({{ $actividad->sesiones->count() }})
                                </a>
                                <a href="{{ route('organizer.actividades.enrollments', $actividad->id) }}" class="text-purple-600 hover:text-purple-800 text-sm">
                                    Inscripciones
                                </a>
                                <a href="{{ route('organizer.certificados.index', $actividad->id) }}" class="text-yellow-600 hover:text-yellow-800 text-sm">
                                    Certificados
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Paginación -->
            <div class="mt-6">
                {{ $actividades->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No tienes actividades</h3>
                <p class="mt-1 text-sm text-gray-500">Comienza creando tu primera actividad</p>
                <div class="mt-6">
                    <a href="{{ route('organizer.actividades.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                        + Nueva Actividad
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
