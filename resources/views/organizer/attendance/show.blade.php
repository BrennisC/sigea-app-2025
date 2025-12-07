@extends('layouts.app')

@section('page-title', 'Asistencia - ' . $sesion->nombre)

@section('content')
<div class="mb-6">
    <div class="flex items-center gap-2 text-sm text-gray-500 mb-2">
        <a href="{{ route('organizer.actividades.show', $sesion->actividad->id) }}" class="hover:text-indigo-600">{{ $sesion->actividad->nombre }}</a>
        <span>/</span>
        <a href="{{ route('organizer.sesiones.index', $sesion->actividad->id) }}" class="hover:text-indigo-600">Sesiones</a>
        <span>/</span>
        <span>Asistencia</span>
    </div>
    <div class="flex justify-between items-start">
        <div>
            <h2 class="text-2xl font-semibold text-gray-900">Registro de Asistencia</h2>
            <div class="mt-1 text-sm text-gray-600">
                <span class="font-medium">Sesión:</span> {{ $sesion->nombre }} <br>
                <span class="font-medium">Fecha:</span> {{ $sesion->fecha_hora_inicio->format('d/m/Y H:i') }}
            </div>
        </div>
        <div class="bg-gray-100 px-4 py-2 rounded-lg text-center">
            <span class="block text-2xl font-bold text-gray-900">{{ $inscripciones->count() }}</span>
            <span class="text-xs text-gray-500 uppercase">Inscritos</span>
        </div>
    </div>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <form action="{{ route('organizer.asistencias.store', $sesion->id) }}" method="POST">
        @csrf
        
        <div class="p-4 bg-gray-50 border-b border-gray-200 flex justify-between items-center">
            <h3 class="font-medium text-gray-700">Listado de Participantes</h3>
            <div class="space-x-2 text-sm">
                <button type="button" onclick="marcarTodos(true)" class="text-indigo-600 hover:text-indigo-800">Marcar Todos</button>
                <span class="text-gray-300">|</span>
                <button type="button" onclick="marcarTodos(false)" class="text-gray-500 hover:text-gray-700">Desmarcar Todos</button>
            </div>
        </div>

        @if($inscripciones->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-10">
                                Asistió
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Participante
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Documento
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Estado Actual
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($inscripciones as $inscripcion)
                            @php
                                $asistencia = $asistenciasMap[$inscripcion->id] ?? null;
                                $isPresente = $asistencia ? $asistencia->presente : false;
                            @endphp
                            <tr class="hover:bg-gray-50 transition-colors {{ $isPresente ? 'bg-green-50' : '' }}">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center h-5">
                                        <input type="hidden" name="asistencias[{{ $inscripcion->id }}]" value="0">
                                        <input id="asistencia_{{ $inscripcion->id }}" name="asistencias[{{ $inscripcion->id }}]" type="checkbox" value="1" 
                                            {{ $isPresente ? 'checked' : '' }}
                                            class="h-5 w-5 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded cursor-pointer asistencia-check">
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <label for="asistencia_{{ $inscripcion->id }}" class="flex items-center cursor-pointer">
                                        <div class="text-sm font-medium text-gray-900">{{ $inscripcion->user->name }}</div>
                                    </label>
                                    <div class="text-sm text-gray-500">{{ $inscripcion->user->email }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $inscripcion->user->dni ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($asistencia)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $asistencia->presente ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $asistencia->presente ? 'Presente' : 'Ausente' }}
                                        </span>
                                        <span class="text-xs text-gray-400 block mt-1">
                                            {{ $asistencia->updated_at->format('H:i d/m') }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">
                                            Sin Registro
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end sticky bottom-0">
                <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 shadow-sm font-medium transition-colors">
                    Guardar Asistencia
                </button>
            </div>
        @else
            <div class="text-center py-12">
                <p class="text-gray-500">No hay participantes inscritos en esta actividad.</p>
                <p class="text-sm text-gray-400 mt-1">No se puede tomar asistencia sin inscritos.</p>
            </div>
        @endif
    </form>
</div>

<script>
    function marcarTodos(estado) {
        const checkboxes = document.querySelectorAll('.asistencia-check');
        checkboxes.forEach(cb => cb.checked = estado);
    }
</script>
@endsection
