@extends('layouts.app')

@section('page-title', 'Gestión de Catálogos')

@section('content')
<div class="space-y-8">
    <!-- Estados -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h2 class="text-xl font-semibold">Estados</h2>
            <button onclick="document.getElementById('modal-estado').classList.remove('hidden')" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                + Nuevo Estado
            </button>
        </div>
        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tipo</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Descripción</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($estados as $estado)
                            <tr>
                                <td class="px-6 py-4">{{ $estado->nombre }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">
                                        {{ $estado->tipo }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $estado->descripcion }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 text-xs rounded-full {{ $estado->activo ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ $estado->activo ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <form method="POST" action="{{ route('admin.catalogos.destroy', ['estados', $estado->id]) }}" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 text-sm">Desactivar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Tipos -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h2 class="text-xl font-semibold">Tipos de Actividades</h2>
            <button onclick="document.getElementById('modal-tipo').classList.remove('hidden')" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                + Nuevo Tipo
            </button>
        </div>
        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Categoría</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Descripción</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($tipos as $tipo)
                            <tr>
                                <td class="px-6 py-4">{{ $tipo->nombre }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 text-xs rounded-full bg-purple-100 text-purple-800">
                                        {{ $tipo->categoria }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $tipo->descripcion }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 text-xs rounded-full {{ $tipo->activo ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ $tipo->activo ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <form method="POST" action="{{ route('admin.catalogos.destroy', ['tipos', $tipo->id]) }}" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 text-sm">Desactivar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Métodos de Pago -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h2 class="text-xl font-semibold">Métodos de Pago</h2>
            <button onclick="document.getElementById('modal-metodo').classList.remove('hidden')" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                + Nuevo Método
            </button>
        </div>
        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Descripción</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($metodosPago as $metodo)
                            <tr>
                                <td class="px-6 py-4">{{ $metodo->nombre }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $metodo->descripcion }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 text-xs rounded-full {{ $metodo->activo ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ $metodo->activo ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <form method="POST" action="{{ route('admin.catalogos.destroy', ['metodos-pago', $metodo->id]) }}" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 text-sm">Desactivar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modales simples (puedes mejorarlos después) -->
<div id="modal-estado" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center">
    <div class="bg-white p-6 rounded-lg max-w-md w-full">
        <h3 class="text-lg font-semibold mb-4">Nuevo Estado</h3>
        <form method="POST" action="{{ route('admin.catalogos.store', 'estados') }}">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium mb-2">Nombre</label>
                    <input type="text" name="nombre" required class="w-full border rounded px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">Tipo</label>
                    <select name="tipo" required class="w-full border rounded px-3 py-2">
                        <option value="actividad">Actividad</option>
                        <option value="inscripcion">Inscripción</option>
                        <option value="pago">Pago</option>
                        <option value="certificado">Certificado</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">Descripción</label>
                    <textarea name="descripcion" class="w-full border rounded px-3 py-2"></textarea>
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="document.getElementById('modal-estado').classList.add('hidden')" class="px-4 py-2 border rounded">Cancelar</button>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded">Guardar</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div id="modal-tipo" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center">
    <div class="bg-white p-6 rounded-lg max-w-md w-full">
        <h3 class="text-lg font-semibold mb-4">Nuevo Tipo</h3>
        <form method="POST" action="{{ route('admin.catalogos.store', 'tipos') }}">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium mb-2">Nombre</label>
                    <input type="text" name="nombre" required class="w-full border rounded px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">Categoría</label>
                    <input type="text" name="categoria" value="actividad" required class="w-full border rounded px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">Descripción</label>
                    <textarea name="descripcion" class="w-full border rounded px-3 py-2"></textarea>
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="document.getElementById('modal-tipo').classList.add('hidden')" class="px-4 py-2 border rounded">Cancelar</button>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded">Guardar</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div id="modal-metodo" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center">
    <div class="bg-white p-6 rounded-lg max-w-md w-full">
        <h3 class="text-lg font-semibold mb-4">Nuevo Método de Pago</h3>
        <form method="POST" action="{{ route('admin.catalogos.store', 'metodos-pago') }}">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium mb-2">Nombre</label>
                    <input type="text" name="nombre" required class="w-full border rounded px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">Descripción</label>
                    <textarea name="descripcion" class="w-full border rounded px-3 py-2"></textarea>
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="document.getElementById('modal-metodo').classList.add('hidden')" class="px-4 py-2 border rounded">Cancelar</button>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded">Guardar</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
