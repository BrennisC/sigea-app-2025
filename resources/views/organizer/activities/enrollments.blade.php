@extends('layouts.app')

@section('page-title', 'Inscripciones - ' . $actividad->nombre)

@section('content')
<div class="mb-6">
    <div class="flex items-center gap-2 text-sm text-gray-500 mb-2">
        <a href="{{ route('organizer.actividades.index') }}" class="hover:text-indigo-600">Mis Actividades</a>
        <span>/</span>
        <a href="{{ route('organizer.actividades.show', $actividad->id) }}" class="hover:text-indigo-600">{{ $actividad->nombre }}</a>
        <span>/</span>
        <span>Inscripciones</span>
    </div>
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-semibold text-gray-900">Listado de Inscritos</h2>
            <p class="text-gray-600">Registro académico y de asistencia de los participantes.</p>
        </div>
        <div class="bg-indigo-50 px-4 py-2 rounded-lg text-indigo-700 font-medium text-sm">
            Total Inscritos: {{ $actividad->inscripciones->count() }} / {{ $actividad->cupo_maximo ?? '∞' }}
        </div>
    </div>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    @if($actividad->inscripciones->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Participante</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha Inscripción</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Asistencia</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado Académico</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Certificado</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($actividad->inscripciones as $inscripcion)
                        @php
                            $porcentaje = $inscripcion->calcularPorcentajeAsistencia();
                            $minimo = $actividad->porcentaje_asistencia_minima;
                            $aprobado = $porcentaje >= $minimo;
                            $totalSesiones = $actividad->sesiones()->count();
                            $asistencias = $inscripcion->asistencias()->where('presente', true)->count();
                        @endphp
                        <tr>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-500 font-bold">
                                        {{ substr($inscripcion->user->name, 0, 1) }}
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $inscripcion->user->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $inscripcion->user->email }}</div>
                                        <div class="text-xs text-gray-400">DNI: {{ $inscripcion->user->dni ?? 'N/A' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $inscripcion->created_at->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold {{ $aprobado ? 'text-green-600' : 'text-red-600' }}">
                                    {{ number_format($porcentaje, 0) }}%
                                </div>
                                <div class="text-xs text-gray-500">
                                    {{ $asistencias }} de {{ $totalSesiones }} sesiones
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($totalSesiones > 0)
                                    @if($aprobado)
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Aprobado
                                        </span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            Reprobado
                                        </span>
                                    @endif
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                        Sin Sesiones
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                @if($inscripcion->certificado)
                                    <a href="{{ route('organizer.certificados.show', $inscripcion->certificado->id) }}" target="_blank" class="text-indigo-600 hover:text-indigo-900 flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        Ver Certificado
                                    </a>
                                @else
                                    <span class="text-gray-400 italic">No emitido</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">No hay inscritos</h3>
            <p class="mt-1 text-sm text-gray-500">Aún no hay participantes registrados en esta actividad.</p>
        </div>
    @endif
</div>
@endsection
