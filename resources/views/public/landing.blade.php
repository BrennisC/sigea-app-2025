@extends('layouts.public')

@section('title', 'Inicio - SIGEA')

@section('content')
<!-- Hero Section -->
<div class="bg-indigo-700 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
        <div class="text-center">
            <h1 class="text-4xl md:text-6xl font-bold mb-6">
                Gestiona tus eventos, asistencias y certificados
            </h1>
            <p class="text-xl md:text-2xl mb-8 text-indigo-100">
                SIGEA te ayuda a organizar actividades, registrar participación y emitir certificados con validación online
            </p>
            <div class="flex justify-center space-x-4">
                <a href="{{ route('actividades.index') }}" class="bg-white text-indigo-700 px-8 py-3 rounded-lg font-semibold hover:bg-indigo-50 transition">
                    Ver Actividades
                </a>
                <a href="/register" class="bg-indigo-500 text-white px-8 py-3 rounded-lg font-semibold hover:bg-indigo-600 transition">
                    Crear Cuenta
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Próximas Actividades -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <h2 class="text-3xl font-bold text-gray-900 mb-8">Próximas Actividades</h2>
    
    @if($proximasActividades->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($proximasActividades as $actividad)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                    @if($actividad->imagen_url)
                        <img src="{{ $actividad->imagen_url }}" alt="{{ $actividad->nombre }}" class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gradient-to-r from-indigo-500 to-purple-600"></div>
                    @endif
                    <div class="p-6">
                        <span class="inline-block px-3 py-1 text-xs font-semibold text-indigo-600 bg-indigo-100 rounded-full mb-2">
                            {{ $actividad->tipo->nombre ?? 'Actividad' }}
                        </span>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $actividad->nombre }}</h3>
                        <p class="text-gray-600 text-sm mb-4">{{ Str::limit($actividad->descripcion, 100) }}</p>
                        <div class="flex justify-between items-center text-sm text-gray-500">
                            <span>📅 {{ $actividad->fecha_inicio->format('d/m/Y') }}</span>
                            <span>{{ $actividad->modalidad }}</span>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('actividades.show', $actividad->id) }}" class="block text-center bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition">
                                Ver Detalle
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-gray-600">No hay actividades próximas en este momento.</p>
    @endif
</div>

<!-- Cómo Funciona -->
<div class="bg-gray-100 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-gray-900 mb-12 text-center">¿Cómo Funciona?</h2>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="text-center">
                <div class="bg-indigo-600 text-white w-16 h-16 rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-4">1</div>
                <h3 class="font-semibold text-lg mb-2">Regístrate</h3>
                <p class="text-gray-600">Crea tu cuenta y verifica tu email</p>
            </div>
            <div class="text-center">
                <div class="bg-indigo-600 text-white w-16 h-16 rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-4">2</div>
                <h3 class="font-semibold text-lg mb-2">Inscríbete</h3>
                <p class="text-gray-600">Elige una actividad y regístrate</p>
            </div>
            <div class="text-center">
                <div class="bg-indigo-600 text-white w-16 h-16 rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-4">3</div>
                <h3 class="font-semibold text-lg mb-2">Participa</h3>
                <p class="text-gray-600">Asiste a las sesiones programadas</p>
            </div>
            <div class="text-center">
                <div class="bg-indigo-600 text-white w-16 h-16 rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-4">4</div>
                <h3 class="font-semibold text-lg mb-2">Recibe tu Certificado</h3>
                <p class="text-gray-600">Obtén tu certificado digital verificable</p>
            </div>
        </div>
    </div>
</div>

<!-- Para Quién Es -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">¿Para Quién Es Esta Plataforma?</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-xl font-semibold mb-3">Organizaciones</h3>
            <p class="text-gray-600">Que dictan talleres, cursos y charlas de capacitación</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-xl font-semibold mb-3">Instituciones</h3>
            <p class="text-gray-600">De capacitación y formación profesional</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-xl font-semibold mb-3">Empresas</h3>
            <p class="text-gray-600">Que quieren formalizar capacitaciones internas</p>
        </div>
    </div>
</div>
@endsection
