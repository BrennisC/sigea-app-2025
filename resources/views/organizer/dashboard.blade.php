@extends('layouts.app')

@section('page-title', 'Dashboard Organizador')

@section('content')
<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm text-gray-500">Mis Actividades</p>
                <p class="text-2xl font-bold text-gray-900">{{ $totalActividades }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm text-gray-500">Total Inscritos</p>
                <p class="text-2xl font-bold text-gray-900">{{ $totalInscritos }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm text-gray-500">Sesiones Programadas</p>
                <p class="text-2xl font-bold text-gray-900">{{ $totalSesiones }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm text-gray-500">Certificados Emitidos</p>
                <p class="text-2xl font-bold text-gray-900">{{ $totalCertificados }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Actividades Recientes -->
<div class="bg-white rounded-lg shadow mb-8">
    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
        <h2 class="text-xl font-semibold">Mis Actividades Recientes</h2>
        <a href="{{ route('organizer.actividades.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 text-sm">
            + Nueva Actividad
        </a>
    </div>
    <div class="p-6">
        @if($actividadesRecientes->count() > 0)
            <div class="space-y-4">
                @foreach($actividadesRecientes as $actividad)
                    <div class="border-l-4 {{ $actividad->estado->nombre === 'Publicada' ? 'border-green-500' : ($actividad->estado->nombre === 'En Curso' ? 'border-blue-500' : 'border-gray-500') }} pl-4 py-2">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="font-semibold text-lg">{{ $actividad->nombre }}</h3>
                                <p class="text-sm text-gray-600">{{ $actividad->tipo->nombre ?? 'N/A' }} • {{ ucfirst($actividad->modalidad) }}</p>
                                <p class="text-sm text-gray-500 mt-1">
                                    📅 {{ $actividad->fecha_inicio->format('d/m/Y') }} - {{ $actividad->fecha_fin->format('d/m/Y') }}
                                    • 👥 {{ $actividad->inscripciones->count() }} inscritos
                                </p>
                            </div>
                            <div class="flex flex-col items-end space-y-2">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full 
                                    {{ $actividad->estado->nombre === 'Publicada' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $actividad->estado->nombre === 'Planificada' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $actividad->estado->nombre === 'En Curso' ? 'bg-blue-100 text-blue-800' : '' }}
                                    {{ $actividad->estado->nombre === 'Finalizada' ? 'bg-gray-100 text-gray-800' : '' }}">
                                    {{ $actividad->estado->nombre ?? 'Sin estado' }}
                                </span>
                                <a href="{{ route('organizer.actividades.show', $actividad->id) }}" class="text-indigo-600 hover:text-indigo-800 text-sm">
                                    Ver detalle →
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8">
                <p class="text-gray-500 mb-4">No tienes actividades creadas aún</p>
                <a href="{{ route('organizer.actividades.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                    + Crear mi primera actividad
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Próximas Sesiones -->
<div class="bg-white rounded-lg shadow">
    <div class="px-6 py-4 border-b border-gray-200">
        <h2 class="text-xl font-semibold">Próximas Sesiones</h2>
    </div>
    <div class="p-6">
        @if($proximasSesiones->count() > 0)
            <div class="space-y-3">
                @foreach($proximasSesiones as $sesion)
                    <div class="flex justify-between items-center border-b pb-3">
                        <div>
                            <p class="font-semibold">{{ $sesion->nombre }}</p>
                            <p class="text-sm text-gray-600">{{ $sesion->actividad->nombre }}</p>
                            <p class="text-sm text-gray-500">
                                📅 {{ $sesion->fecha_hora_inicio->format('d/m/Y H:i') }}
                            </p>
                        </div>
                        <div class="text-right">
                            <a href="{{ route('organizer.sesiones.edit', $sesion->id) }}" class="text-indigo-600 hover:text-indigo-800 text-sm">
                                Editar
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-center text-gray-500 py-4">No hay sesiones programadas</p>
        @endif
    </div>
</div>
@endsection
