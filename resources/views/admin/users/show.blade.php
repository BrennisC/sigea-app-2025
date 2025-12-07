@extends('layouts.app')

@section('page-title', 'Detalle de Usuario')

@section('content')
<div class="max-w-4xl">
    <div class="mb-4">
        <a href="{{ route('admin.usuarios.index') }}" class="text-indigo-600 hover:text-indigo-800">
            ← Volver a usuarios
        </a>
    </div>

    <!-- Información del Usuario -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h2 class="text-2xl font-semibold mb-6">Información Personal</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700">Nombre</label>
                <p class="mt-1 text-lg">{{ $usuario->name }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <p class="mt-1 text-lg">{{ $usuario->email }}</p>
                @if($usuario->email_verified_at)
                    <span class="text-sm text-green-600">✓ Verificado el {{ $usuario->email_verified_at->format('d/m/Y') }}</span>
                @else
                    <span class="text-sm text-gray-500">Sin verificar</span>
                @endif
            </div>
            @if($usuario->telefono)
                <div>
                    <label class="block text-sm font-medium text-gray-700">Teléfono</label>
                    <p class="mt-1">{{ $usuario->telefono }}</p>
                </div>
            @endif
            @if($usuario->documento_identidad)
                <div>
                    <label class="block text-sm font-medium text-gray-700">Documento de Identidad</label>
                    <p class="mt-1">{{ $usuario->documento_identidad }}</p>
                </div>
            @endif
            @if($usuario->direccion)
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Dirección</label>
                    <p class="mt-1">{{ $usuario->direccion }}</p>
                </div>
            @endif
            <div>
                <label class="block text-sm font-medium text-gray-700">Estado</label>
                <p class="mt-1">
                    <span class="px-3 py-1 rounded-full text-sm {{ $usuario->activo ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                        {{ $usuario->activo ? 'Activo' : 'Inactivo' }}
                    </span>
                </p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Fecha de Registro</label>
                <p class="mt-1">{{ $usuario->created_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>
    </div>

    <!-- Roles -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h2 class="text-xl font-semibold mb-4">Roles Asignados</h2>
        <form method="POST" action="{{ route('admin.usuarios.roles.update', $usuario->id) }}">
            @csrf
            @method('PATCH')
            <div class="space-y-2 mb-4">
                @foreach(\App\Models\Rol::where('activo', true)->get() as $rol)
                    <label class="flex items-center">
                        <input type="checkbox" name="roles[]" value="{{ $rol->id }}" 
                            {{ $usuario->roles->contains($rol->id) ? 'checked' : '' }}
                            class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        <span class="ml-2">{{ $rol->nombre_rol }}</span>
                    </label>
                @endforeach
            </div>
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                Actualizar Roles
            </button>
        </form>
    </div>

    <!-- Estadísticas -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-sm text-gray-500">Inscripciones</h3>
            <p class="text-3xl font-bold">{{ $usuario->inscripciones->count() }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-sm text-gray-500">Certificados</h3>
            <p class="text-3xl font-bold">{{ $usuario->certificados->count() }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-sm text-gray-500">Actividades Organizadas</h3>
            <p class="text-3xl font-bold">{{ $usuario->actividadesOrganizadas->count() }}</p>
        </div>
    </div>

    <!-- Actividades Recientes -->
    @if($usuario->inscripciones->count() > 0)
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold mb-4">Actividades Inscritas</h2>
            <div class="space-y-3">
                @foreach($usuario->inscripciones->take(5) as $inscripcion)
                    <div class="border-l-4 border-indigo-500 pl-4 py-2">
                        <h3 class="font-semibold">{{ $inscripcion->actividad->nombre }}</h3>
                        <p class="text-sm text-gray-600">Estado: {{ $inscripcion->estado->nombre ?? 'N/A' }}</p>
                        <p class="text-sm text-gray-500">{{ $inscripcion->created_at->format('d/m/Y') }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
