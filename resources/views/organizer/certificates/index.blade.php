@extends('layouts.app')

@section('page-title', 'Gestión de Certificados - ' . $actividad->nombre)

@section('content')
<div class="mb-6">
    <div class="flex items-center gap-2 text-sm text-gray-500 mb-2">
        <a href="{{ route('organizer.actividades.index') }}" class="hover:text-indigo-600">Mis Actividades</a>
        <span>/</span>
        <a href="{{ route('organizer.actividades.show', $actividad->id) }}" class="hover:text-indigo-600">{{ $actividad->nombre }}</a>
        <span>/</span>
        <span>Certificados</span>
    </div>
    <h2 class="text-2xl font-semibold text-gray-900">Gestión de Certificados</h2>
</div>

<!-- Stats -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
        <p class="text-sm text-gray-500 uppercase font-bold">Total Inscritos</p>
        <p class="text-3xl font-bold text-gray-900">{{ $totalInscritos }}</p>
    </div>
    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500">
        <p class="text-sm text-gray-500 uppercase font-bold">Emitidos</p>
        <p class="text-3xl font-bold text-gray-900">{{ $certificadosEmitidos }}</p>
    </div>
    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-yellow-500">
        <p class="text-sm text-gray-500 uppercase font-bold">Pendientes Elegibles</p>
        <p class="text-3xl font-bold text-gray-900">{{ $participantesElegibles->count() }}</p>
    </div>
</div>

<!-- Actions -->
<div class="bg-white rounded-lg shadow mb-8 p-6">
    <h3 class="text-lg font-semibold text-gray-900 mb-4">Generación Masiva</h3>
    <div class="bg-gray-50 p-4 rounded-lg flex items-center justify-between">
        <div>
            <p class="text-gray-700">Generar certificados para <strong>{{ $participantesElegibles->count() }}</strong> participantes elegibles.</p>
            <p class="text-sm text-gray-500 mt-1">Se generarán certificados solo para quienes cumplan con el {{ $actividad->porcentaje_asistencia_minima }}% de asistencia mínima.</p>
        </div>
        <form action="{{ route('organizer.certificados.generate') }}" method="POST">
            @csrf
            <input type="hidden" name="actividad_id" value="{{ $actividad->id }}">
            <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 transition disabled:opacity-50 disabled:cursor-not-allowed" 
                {{ $participantesElegibles->count() == 0 ? 'disabled' : '' }}>
                Generar Certificados
            </button>
        </form>
    </div>
</div>

<!-- List of Issued Certificates -->
<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-semibold text-gray-900">Certificados Emitidos</h3>
    </div>
    
    @if($certificados->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Participante</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha Emisión</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Código</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($certificados as $certificado)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $certificado->user->name }}</div>
                                <div class="text-sm text-gray-500">{{ $certificado->user->email }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $certificado->fecha_emision->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 font-mono">
                                    {{ $certificado->codigo_validacion }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('organizer.certificados.show', $certificado->id) }}" target="_blank" class="text-indigo-600 hover:text-indigo-900">Ver Certificado</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $certificados->links() }}
        </div>
    @else
        <div class="text-center py-12">
            <p class="text-gray-500">No se han emitido certificados para esta actividad aún.</p>
        </div>
    @endif
</div>
@endsection
