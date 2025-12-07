@extends('layouts.public')

@section('title', 'Validar Certificado - SIGEA')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="bg-white rounded-lg shadow-lg p-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-6 text-center">Validar Certificado</h1>
        <p class="text-gray-600 text-center mb-8">Ingresa el código de validación para verificar la autenticidad del certificado</p>

        <!-- Formulario de Validación -->
        <form method="POST" action="{{ route('certificados.validar') }}" class="mb-8">
            @csrf
            <div class="flex gap-4">
                <input 
                    type="text" 
                    name="codigo" 
                    placeholder="Código de validación" 
                    class="flex-1 border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 uppercase"
                    value="{{ old('codigo') }}"
                    required
                >
                <button type="submit" class="bg-indigo-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-indigo-700 transition">
                    Validar
                </button>
            </div>
            @error('codigo')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </form>

        <!-- Resultado de Validación -->
        @if(isset($certificado))
            <div class="border-t pt-8">
                <div class="bg-green-50 border-l-4 border-green-500 p-6 mb-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-8 w-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-green-800">Certificado Válido ✓</h3>
                            <p class="text-green-700">Este certificado es auténtico y está activo</p>
                        </div>
                    </div>
                </div>

                <!-- Detalles del Certificado -->
                <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Código de Validación</p>
                            <p class="font-semibold text-lg">{{ $certificado->codigo_validacion }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Fecha de Emisión</p>
                            <p class="font-semibold">{{ $certificado->fecha_emision->format('d/m/Y') }}</p>
                        </div>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Participante</p>
                        <p class="font-semibold text-lg">{{ $certificado->user->name }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Actividad</p>
                        <p class="font-semibold text-lg">{{ $certificado->actividad->nombre }}</p>
                    </div>

                    @if($certificado->horas_certificadas)
                        <div>
                            <p class="text-sm text-gray-500">Horas Certificadas</p>
                            <p class="font-semibold">{{ $certificado->horas_certificadas }} horas</p>
                        </div>
                    @endif

                    @if($certificado->porcentaje_asistencia)
                        <div>
                            <p class="text-sm text-gray-500">Asistencia</p>
                            <p class="font-semibold">{{ number_format($certificado->porcentaje_asistencia, 2) }}%</p>
                        </div>
                    @endif

                    <div class="pt-4 border-t">
                        <p class="text-xs text-gray-500">
                            Este certificado fue generado por {{ $certificado->generadoPor->name ?? 'Sistema' }} 
                            el {{ $certificado->created_at->format('d/m/Y H:i') }}
                        </p>
                    </div>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-50 border-l-4 border-red-500 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-8 w-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-red-800">Certificado No Válido</h3>
                        <p class="text-red-700">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Información Adicional -->
    <div class="mt-8 text-center text-gray-600">
        <p class="text-sm">El código de validación se encuentra en la parte inferior del certificado</p>
        <p class="text-sm mt-2">Cada validación queda registrada en el sistema</p>
    </div>
</div>
@endsection
