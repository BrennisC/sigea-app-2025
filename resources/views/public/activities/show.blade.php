@extends('layouts.public')

@section('title', $actividad->nombre . ' - SIGEA')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Breadcrumb -->
    <nav class="mb-6">
        <ol class="flex items-center space-x-2 text-sm text-gray-500">
            <li><a href="{{ route('landing') }}" class="hover:text-indigo-600">Inicio</a></li>
            <li>/</li>
            <li><a href="{{ route('actividades.index') }}" class="hover:text-indigo-600">Actividades</a></li>
            <li>/</li>
            <li class="text-gray-900">{{ $actividad->nombre }}</li>
        </ol>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Contenido Principal -->
        <div class="lg:col-span-2">
            <!-- Imagen -->
            @if($actividad->imagen_url)
                <img src="{{ $actividad->imagen_url }}" alt="{{ $actividad->nombre }}" class="w-full h-96 object-cover rounded-lg mb-6">
            @else
                <div class="w-full h-96 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-lg mb-6 flex items-center justify-center">
                    <span class="text-white text-6xl">📚</span>
                </div>
            @endif

            <!-- Título y Descripción -->
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <div class="flex items-center space-x-2 mb-4">
                    <span class="px-3 py-1 text-sm font-semibold text-indigo-600 bg-indigo-100 rounded-full">
                        {{ $actividad->tipo->nombre ?? 'Actividad' }}
                    </span>
                    <span class="px-3 py-1 text-sm font-semibold text-gray-600 bg-gray-100 rounded-full">
                        {{ ucfirst($actividad->modalidad) }}
                    </span>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $actividad->nombre }}</h1>
                <p class="text-gray-700 whitespace-pre-line">{{ $actividad->descripcion }}</p>
            </div>

            <!-- Sesiones -->
            @if($actividad->sesiones->count() > 0)
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-2xl font-semibold mb-4">Sesiones</h2>
                    <div class="space-y-4">
                        @foreach($actividad->sesiones as $sesion)
                            <div class="border-l-4 border-indigo-500 pl-4 py-2">
                                <h3 class="font-semibold text-lg">{{ $sesion->nombre }}</h3>
                                <p class="text-sm text-gray-600">{{ $sesion->descripcion }}</p>
                                <div class="flex items-center space-x-4 mt-2 text-sm text-gray-500">
                                    <span>📅 {{ $sesion->fecha_hora_inicio->format('d/m/Y H:i') }}</span>
                                    @if($sesion->duracion_minutos)
                                        <span>⏱️ {{ $sesion->duracion_minutos }} min</span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow p-6 sticky top-6">
                <h3 class="text-xl font-semibold mb-4">Información</h3>
                
                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-gray-500">Organizador</p>
                        <p class="font-semibold">{{ $actividad->organizador->name }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Fechas</p>
                        <p class="font-semibold">{{ $actividad->fecha_inicio->format('d/m/Y') }} - {{ $actividad->fecha_fin->format('d/m/Y') }}</p>
                    </div>

                    @if($actividad->horas_totales)
                        <div>
                            <p class="text-sm text-gray-500">Duración</p>
                            <p class="font-semibold">{{ $actividad->horas_totales }} horas</p>
                        </div>
                    @endif

                    <div>
                        <p class="text-sm text-gray-500">Precio</p>
                        @if($actividad->precio > 0)
                            <p class="font-semibold text-green-600 text-2xl">${{ number_format($actividad->precio, 2) }}</p>
                        @else
                            <p class="font-semibold text-green-600 text-2xl">Gratis</p>
                        @endif
                    </div>

                    @if($actividad->cupo_maximo)
                        <div>
                            <p class="text-sm text-gray-500">Cupo</p>
                            <p class="font-semibold">{{ $inscritosCount }} / {{ $actividad->cupo_maximo }} inscritos</p>
                            @if($cupoDisponible !== null)
                                <div class="mt-2 bg-gray-200 rounded-full h-2">
                                    <div class="bg-indigo-600 h-2 rounded-full" style="width: {{ ($inscritosCount / $actividad->cupo_maximo) * 100 }}%"></div>
                                </div>
                            @endif
                        </div>
                    @endif

                    @if($actividad->modalidad === 'presencial' && $actividad->ubicacion)
                        <div>
                            <p class="text-sm text-gray-500">Ubicación</p>
                            <p class="font-semibold">{{ $actividad->ubicacion }}</p>
                        </div>
                    @endif

                    @if($actividad->modalidad === 'virtual' && $actividad->url_virtual)
                        <div>
                            <p class="text-sm text-gray-500">Plataforma</p>
                            <p class="font-semibold text-indigo-600">Virtual</p>
                        </div>
                    @endif
                </div>

                @auth
                    <form action="{{ route('participant.enrollments.store') }}" method="POST" class="mt-6">
                        @csrf
                        <input type="hidden" name="actividad_id" value="{{ $actividad->id }}">
                        <button type="submit" class="w-full bg-indigo-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-indigo-700 transition">
                            Inscribirse Ahora
                        </button>
                    </form>
                @else
                    <a href="/login" class="block mt-6 text-center bg-indigo-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-indigo-700 transition">
                        Iniciar Sesión para Inscribirse
                    </a>
                @endauth
            </div>
        </div>
    </div>
</div>
@endsection
