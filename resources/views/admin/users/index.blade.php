@extends('layouts.app')

@section('page-title', 'Gestión de Usuarios')

@section('content')
<div class="mb-6">
    <!-- Filtros -->
    <form method="GET" class="bg-white p-4 rounded-lg shadow mb-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Buscar</label>
                <input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="Nombre, email o DNI..." class="w-full border border-gray-300 rounded-md px-4 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Rol</label>
                <select name="rol" class="w-full border border-gray-300 rounded-md px-4 py-2">
                    <option value="">Todos los roles</option>
                    @foreach($roles as $rol)
                        <option value="{{ $rol->id }}" {{ request('rol') == $rol->id ? 'selected' : '' }}>
                            {{ $rol->nombre_rol }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Estado</label>
                <select name="activo" class="w-full border border-gray-300 rounded-md px-4 py-2">
                    <option value="">Todos</option>
                    <option value="1" {{ request('activo') === '1' ? 'selected' : '' }}>Activos</option>
                    <option value="0" {{ request('activo') === '0' ? 'selected' : '' }}>Inactivos</option>
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                    Filtrar
                </button>
            </div>
        </div>
    </form>

    <!-- Tabla de Usuarios -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Usuario</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Roles</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Registro</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($usuarios as $usuario)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $usuario->name }}</div>
                                    @if($usuario->documento_identidad)
                                        <div class="text-sm text-gray-500">DNI: {{ $usuario->documento_identidad }}</div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $usuario->email }}</div>
                            @if($usuario->email_verified_at)
                                <span class="text-xs text-green-600">✓ Verificado</span>
                            @else
                                <span class="text-xs text-gray-500">Sin verificar</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-wrap gap-1">
                                @foreach($usuario->roles as $rol)
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                        {{ $rol->nombre_rol === 'ADMINISTRADOR' ? 'bg-red-100 text-red-800' : '' }}
                                        {{ $rol->nombre_rol === 'ORGANIZADOR' ? 'bg-blue-100 text-blue-800' : '' }}
                                        {{ $rol->nombre_rol === 'PARTICIPANTE' ? 'bg-green-100 text-green-800' : '' }}">
                                        {{ $rol->nombre_rol }}
                                    </span>
                                @endforeach
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <form method="POST" action="{{ route('admin.usuarios.estado.toggle', $usuario->id) }}" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="px-2 py-1 text-xs font-semibold rounded-full {{ $usuario->activo ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $usuario->activo ? 'Activo' : 'Inactivo' }}
                                </button>
                            </form>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $usuario->created_at->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('admin.usuarios.show', $usuario->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">
                                Ver
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            No se encontraron usuarios
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Paginación -->
    <div class="mt-4">
        {{ $usuarios->links() }}
    </div>
</div>
@endsection
