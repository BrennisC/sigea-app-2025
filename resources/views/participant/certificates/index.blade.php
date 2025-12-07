@extends('layouts.app')

@section('page-title', 'Mis Certificados')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-semibold text-gray-900">Mis Certificados</h2>
    <p class="text-gray-600">Descarga tus certificados de las actividades completadas.</p>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    @if($certificados->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 p-6">
            @foreach($certificados as $certificado)
                <div class="border rounded-lg shadow-sm hover:shadow-md transition duration-200">
                    <div class="p-5">
                        <div class="flex items-center justify-between mb-4">
                            <span class="bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded">
                                Certificado
                            </span>
                            <span class="text-sm text-gray-500">
                                {{ $certificado->fecha_emision->format('d/m/Y') }}
                            </span>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $certificado->actividad->nombre }}</h3>
                        <p class="text-sm text-gray-600 mb-4">
                            Código: <span class="font-mono bg-gray-100 px-1 rounded">{{ $certificado->codigo_validacion }}</span>
                        </p>
                        <a href="{{ route('participant.certificates.download', $certificado->id) }}" class="block w-full text-center bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition duration-150">
                            <span class="flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                </svg>
                                Descargar PDF
                            </span>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $certificados->links() }}
        </div>
    @else
        <div class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">No tienes certificados aún</h3>
            <p class="mt-1 text-sm text-gray-500">Completa actividades para obtener tus certificados.</p>
        </div>
    @endif
</div>
@endsection
