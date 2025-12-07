@extends('layouts.app')

@section('page-title', 'Dashboard Administrador')

@section('content')
<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow p-6">
        <p class="text-sm text-gray-500">Total Usuarios</p>
        <p class="text-3xl font-bold text-gray-900">{{ $totalUsuarios }}</p>
    </div>
    <div class="bg-white rounded-lg shadow p-6">
        <p class="text-sm text-gray-500">Total Actividades</p>
        <p class="text-3xl font-bold text-gray-900">{{ $totalActividades }}</p>
    </div>
    <div class="bg-white rounded-lg shadow p-6">
        <p class="text-sm text-gray-500">Total Inscripciones</p>
        <p class="text-3xl font-bold text-gray-900">{{ $totalInscripciones }}</p>
    </div>
    <div class="bg-white rounded-lg shadow p-6">
        <p class="text-sm text-gray-500">Certificados Emitidos</p>
        <p class="text-3xl font-bold text-gray-900">{{ $totalCertificados }}</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Actividades Recientes -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b">
            <h2 class="text-xl font-semibold">Actividades Recientes</h2>
        </div>
        <div class="p-6">
            <div class="space-y-3">
                @foreach($actividadesRecientes as $actividad)
                    <div class="flex justify-between items-center py-2 border-b">
                        <div>
                            <p class="font-semibold">{{ $actividad->nombre }}</p>
                            <p class="text-sm text-gray-500">Por {{ $actividad->organizador->name }}</p>
                        </div>
                        <span class="text-xs px-2 py-1 rounded bg-gray-100">{{ $actividad->estado->nombre }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Usuarios Recientes -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b">
            <h2 class="text-xl font-semibold">Usuarios Recientes</h2>
        </div>
        <div class="p-6">
            <div class="space-y-3">
                @foreach($usuariosRecientes as $usuario)
                    <div class="flex justify-between items-center py-2 border-b">
                        <div>
                            <p class="font-semibold">{{ $usuario->name }}</p>
                            <p class="text-sm text-gray-500">{{ $usuario->email }}</p>
                        </div>
                        <span class="text-xs text-gray-500">{{ $usuario->created_at->diffForHumans() }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
