@extends('layouts.public')

@section('title', 'Actividades - SIGEA')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Actividades Disponibles</h1>
    
    <!-- Filtros -->
    <form method="GET" class="bg-white p-6 rounded-lg shadow mb-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Buscar</label>
                <input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="Nombre o descripción..." class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tipo</label>
                <select name="tipo" class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Todos los tipos</option>
                    @foreach($tipos as $tipo)
                        <option value="{{ $tipo->id }}" {{ request('tipo') == $tipo->id ? 'selected' : '' }}>
                            {{ $tipo->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Modalidad</label>
                <select name="modalidad" class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Todas</option>
                    @foreach($modalidades as $modalidad)
                        <option value="{{ $modalidad }}" {{ request('modalidad') == $modalidad ? 'selected' : '' }}>
                            {{ ucfirst($modalidad) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition">
                    Filtrar
                </button>
            </div>
        </div>
    </form>
    
    <!-- Grid de Actividades -->
    @if($actividades->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($actividades as $actividad)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
                    @if($actividad->imagen_url)
                        <img src="{{ $actividad->imagen_url }}" alt="{{ $actividad->nombre }}" class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gradient-to-r from-indigo-500 to-purple-600 flex items-center justify-center">
                            <span class="text-white text-4xl">📚</span>
                        </div>
                    @endif
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-2">
                            <span class="inline-block px-3 py-1 text-xs font-semibold text-indigo-600 bg-indigo-100 rounded-full">
                                {{ $actividad->tipo->nombre ?? 'Actividad' }}
                            </span>
                            <span class="text-xs text-gray-500">{{ ucfirst($actividad->modalidad) }}</span>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $actividad->nombre }}</h3>
                        <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $actividad->descripcion }}</p>
                        <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                            <span>📅 {{ $actividad->fecha_inicio->format('d/m/Y') }}</span>
                            @if($actividad->precio > 0)
                                <span class="font-semibold text-green-600">${{ number_format($actividad->precio, 2) }}</span>
                            @else
                                <span class="font-semibold text-green-600">Gratis</span>
                            @endif
                        </div>
                        <a href="{{ route('actividades.show', $actividad->id) }}" class="block text-center bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition">
                            Ver Detalle
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Paginación -->
        <div class="mt-8">
            {{ $actividades->links() }}
        </div>
    @else
        <div class="bg-white rounded-lg shadow p-12 text-center">
            <p class="text-gray-500 text-lg">No se encontraron actividades con los filtros seleccionados.</p>
        </div>
    @endif
</div>
@endsection

