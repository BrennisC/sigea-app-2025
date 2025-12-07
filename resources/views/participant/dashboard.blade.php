@extends('layouts.app')

@section('page-title', 'Dashboard')

@section('content')
<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0 bg-indigo-100 rounded-lg p-3">
                <svg class="h-8 w-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm text-gray-500">Total Inscripciones</p>
                <p class="text-2xl font-bold text-gray-900">{{ $totalInscripciones }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0 bg-green-100 rounded-lg p-3">
                <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm text-gray-500">Certificados</p>
                <p class="text-2xl font-bold text-gray-900">{{ $totalCertificados }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0 bg-yellow-100 rounded-lg p-3">
                <svg class="h-8 w-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm text-gray-500">Notificaciones</p>
                <p class="text-2xl font-bold text-gray-900">{{ $notificaciones->count() }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Próximas Actividades -->
<div class="bg-white rounded-lg shadow mb-8">
    <div class="px-6 py-4 border-b border-gray-200">
        <h2 class="text-xl font-semibold text-gray-900">Próximas Actividades</h2>
    </div>
    <div class="p-6">
        @if($proximasActividades->count() > 0)
            <div class="space-y-4">
                @foreach($proximasActividades as $inscripcion)
                    <div class="border-l-4 border-indigo-500 pl-4 py-3 hover:bg-gray-50 transition">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="font-semibold text-lg text-gray-900">{{ $inscripcion->actividad->nombre }}</h3>
                                <p class="text-sm text-gray-600 mt-1">{{ Str::limit($inscripcion->actividad->descripcion, 100) }}</p>
                                <div class="flex items-center space-x-4 mt-2 text-sm text-gray-500">
                                    <span>📅 {{ $inscripcion->actividad->fecha_inicio->format('d/m/Y') }}</span>
                                    <span>{{ ucfirst($inscripcion->actividad->modalidad) }}</span>
                                    @if($inscripcion->actividad->sesiones->count() > 0)
                                        <span>{{ $inscripcion->actividad->sesiones->count() }} sesiones</span>
                                    @endif
                                </div>
                            </div>
                            <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $inscripcion->estado->nombre === 'Confirmada' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ $inscripcion->estado->nombre ?? 'Pendiente' }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-4">
                <a href="{{ route('participant.actividades.index') }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
                    Ver todas mis actividades →
                </a>
            </div>
        @else
            <p class="text-gray-500 text-center py-8">No tienes actividades próximas. <a href="{{ route('actividades.index') }}" class="text-indigo-600 hover:text-indigo-800">Explora actividades disponibles</a></p>
        @endif
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Últimos Certificados -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-900">Últimos Certificados</h2>
        </div>
        <div class="p-6">
            @if($ultimosCertificados->count() > 0)
                <div class="space-y-4">
                    @foreach($ultimosCertificados as $certificado)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div>
                                <p class="font-semibold text-gray-900">{{ $certificado->actividad->nombre }}</p>
                                <p class="text-sm text-gray-500">{{ $certificado->fecha_emision->format('d/m/Y') }}</p>
                            </div>
                            <a href="{{ route('participant.certificates.download', $certificado->id) }}" class="text-indigo-600 hover:text-indigo-800">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </a>
                        </div>
                    @endforeach
                </div>
                <div class="mt-4">
                    <a href="{{ route('participant.certificates.index') }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
                        Ver todos mis certificados →
                    </a>
                </div>
            @else
                <p class="text-gray-500 text-center py-8">Aún no tienes certificados</p>
            @endif
        </div>
    </div>

    <!-- Notificaciones -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-900">Notificaciones Recientes</h2>
        </div>
        <div class="p-6">
            @if($notificaciones->count() > 0)
                <div class="space-y-3">
                    @foreach($notificaciones as $notificacion)
                        <div class="p-3 bg-blue-50 border-l-4 border-blue-500 rounded">
                            <p class="font-semibold text-sm text-gray-900">{{ $notificacion->titulo }}</p>
                            <p class="text-sm text-gray-600 mt-1">{{ $notificacion->mensaje }}</p>
                            <p class="text-xs text-gray-500 mt-2">{{ $notificacion->created_at->diffForHumans() }}</p>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-8">No tienes notificaciones nuevas</p>
            @endif
        </div>
    </div>
</div>
@endsection
