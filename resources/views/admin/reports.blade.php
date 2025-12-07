@extends('layouts.app')

@section('page-title', 'Reportes')

@section('content')
<div class="space-y-6">
    <!-- Resumen General -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-sm text-gray-500 mb-2">Total Usuarios</h3>
            <p class="text-3xl font-bold text-gray-900">{{ \App\Models\User::count() }}</p>
            <p class="text-sm text-gray-500 mt-2">Registrados en el sistema</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-sm text-gray-500 mb-2">Total Actividades</h3>
            <p class="text-3xl font-bold text-indigo-600">{{ \App\Models\Actividad::count() }}</p>
            <p class="text-sm text-gray-500 mt-2">Creadas hasta la fecha</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-sm text-gray-500 mb-2">Total Inscripciones</h3>
            <p class="text-3xl font-bold text-green-600">{{ \App\Models\Inscripcion::count() }}</p>
            <p class="text-sm text-gray-500 mt-2">Participantes inscritos</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-sm text-gray-500 mb-2">Certificados Emitidos</h3>
            <p class="text-3xl font-bold text-yellow-600">{{ \App\Models\Certificado::where('activo', true)->count() }}</p>
            <p class="text-sm text-gray-500 mt-2">Certificados activos</p>
        </div>
    </div>

    <!-- Actividades por Estado -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-semibold mb-4">Actividades por Estado</h2>
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
            @php
                $actividadesPorEstado = \App\Models\Actividad::with('estado')->get()->groupBy('estado.nombre');
            @endphp
            @foreach($actividadesPorEstado as $estado => $actividades)
                <div class="border rounded-lg p-4 text-center">
                    <p class="text-2xl font-bold">{{ $actividades->count() }}</p>
                    <p class="text-sm text-gray-600">{{ $estado }}</p>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Usuarios por Rol -->
    <!-- Usuarios por Rol -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-semibold mb-4">Usuarios por Rol</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @foreach(\App\Models\Rol::all() as $rol)
                @php
                    $count = \App\Models\User::whereHas('roles', function($q) use ($rol) {
                        $q->where('rol_id', $rol->id);
                    })->count();
                @endphp
                <div class="border rounded-lg p-4">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm text-gray-600">{{ $rol->nombre_rol }}</p>
                            <p class="text-2xl font-bold">{{ $count }}</p>
                        </div>
                        <div class="text-gray-500">
                            @if($rol->nombre_rol === 'ADMINISTRADOR')
                                <x-heroicon-o-shield-check class="w-8 h-8" />
                            @elseif($rol->nombre_rol === 'ORGANIZADOR')
                                <x-heroicon-o-clipboard-document-list class="w-8 h-8" />
                            @else
                                <x-heroicon-o-user-group class="w-8 h-8" />
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>


    <!-- Actividades Recientes -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-semibold mb-4">Últimas Actividades Creadas</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actividad</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Organizador</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tipo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Inscritos</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach(\App\Models\Actividad::with(['organizador', 'tipo', 'estado'])->orderBy('created_at', 'desc')->take(10)->get() as $actividad)
                        <tr>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ $actividad->nombre }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $actividad->organizador->name }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">
                                    {{ $actividad->tipo->nombre ?? 'N/A' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs rounded-full 
                                    {{ $actividad->estado->nombre === 'Publicada' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $actividad->estado->nombre === 'Planificada' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $actividad->estado->nombre === 'Finalizada' ? 'bg-gray-100 text-gray-800' : '' }}">
                                    {{ $actividad->estado->nombre ?? 'N/A' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $actividad->inscripciones->count() }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $actividad->created_at->format('d/m/Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Inscripciones Recientes -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-semibold mb-4">Últimas Inscripciones</h2>
        <div class="space-y-3">
            @foreach(\App\Models\Inscripcion::with(['user', 'actividad', 'estado'])->orderBy('created_at', 'desc')->take(10)->get() as $inscripcion)
                <div class="flex justify-between items-center border-b pb-3">
                    <div>
                        <p class="font-semibold">{{ $inscripcion->user->name }}</p>
                        <p class="text-sm text-gray-600">{{ $inscripcion->actividad->nombre }}</p>
                    </div>
                    <div class="text-right">
                        <span class="px-2 py-1 text-xs rounded-full {{ $inscripcion->estado->nombre === 'Confirmada' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ $inscripcion->estado->nombre ?? 'Pendiente' }}
                        </span>
                        <p class="text-sm text-gray-500 mt-1">{{ $inscripcion->created_at->diffForHumans() }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Nota -->
    <div class="bg-blue-50 border-l-4 border-blue-500 p-4">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm text-blue-700">
                    Esta es una vista de reportes básica. Puedes expandirla agregando gráficos, exportación a PDF/Excel, y filtros por fecha.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
