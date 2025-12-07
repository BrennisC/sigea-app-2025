<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Panel - SIGEA')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])


</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-gray-800 text-white">
           <div class="bg-gradient-to-r from-blue-600 to-blue-700 p-6 shadow-lg">
        <div class="flex items-center space-x-3">
            <div>
                <h2 class="text-2xl font-bold tracking-wider">SIGEA</h2>
                <p class="text-xs text-blue-200 uppercase tracking-widest">Eventos</p>
            </div>
        </div>
    </div>

    <!-- User Info -->
    <div class="px-6 py-4 border-b border-gray-700">
        <div class="flex items-center space-x-3">
            
            <div class="flex-1 min-w-0">
                <p class="text-sm font-semibold text-white truncate">{{ auth()->user()->name }}</p>
                <p class="text-xs text-gray-400">Conectado</p>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 overflow-y-auto px-4 py-6 space-y-2">
        @if(auth()->user()->tieneRol('ADMINISTRADOR'))
            @include('partials.sidebar-admin')
        @elseif(auth()->user()->tieneRol('ORGANIZADOR'))
            @include('partials.sidebar-organizer')
        @else
            @include('partials.sidebar-participant')
        @endif
    </nav>

    <!-- Logout Button -->
    <div class="px-4 py-4 border-t border-gray-700">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" 
                class="w-full flex items-center justify-center space-x-2 px-4 py-3 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium transition duration-200 ease-in-out transform hover:scale-105 shadow-md">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                </svg>
                <span>Salir</span>
            </button>
        </form>
    </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1">
            <!-- Top Bar -->
            <header class="bg-white shadow">
                <div class="px-6 py-4">
                    <h1 class="text-2xl font-semibold text-gray-800">
                        @yield('page-title', 'Dashboard')
                    </h1>
                </div>
            </header>

            <!-- Content -->
            <main class="p-6">
                <!-- Alerts -->
                @if(session('success'))
                    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                        {{ session('error') }}
                    </div>
                @endif

                @if(session('info'))
                    <div class="mb-4 bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded">
                        {{ session('info') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
