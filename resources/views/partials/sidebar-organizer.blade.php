@php
    $activeClass = 'bg-gray-900 text-white';
    $inactiveClass = 'text-gray-300 hover:bg-gray-700 hover:text-white';
@endphp

<a href="{{ route('organizer.dashboard') }}" class="flex px-4 py-2 text-sm rounded items-center gap-2 {{ request()->routeIs('organizer.dashboard') ? $activeClass : $inactiveClass }}">
    <x-heroicon-o-chart-pie class="w-5 h-5" />
    Dashboard
</a>

<div class="mt-4 mb-2 px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">
    Gestión de Actividades
</div>


<a href="{{ route('organizer.actividades.index') }}" class="flex px-4 py-2 text-sm rounded items-center gap-2 {{ (request()->routeIs('organizer.actividades.*', 'organizer.sesiones.*', 'organizer.certificados.index') && !request()->routeIs('organizer.actividades.create')) ? $activeClass : $inactiveClass }}">
    <x-heroicon-o-calendar class="w-5 h-5" />
    Mis Actividades
</a>

<a href="{{ route('organizer.actividades.create') }}" class="flex px-4 py-2 text-sm rounded items-center gap-2 {{ request()->routeIs('organizer.actividades.create') ? $activeClass : $inactiveClass }}">
    <x-heroicon-o-plus-circle class="w-5 h-5" />
    Nueva Actividad
</a>

<div class="mt-4 mb-2 px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">
    Gestión de Asistencia
</div>

<a href="{{ route('organizer.attendance.index') }}" class="flex px-4 py-2 text-sm rounded items-center gap-2 {{ request()->routeIs('organizer.attendance.index') ? $activeClass : $inactiveClass }}">
    <x-heroicon-o-user-group class="w-5 h-5" />
    Asistencia
</a>

<div class="mt-4 mb-2 px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">
    Gestión de Sesiones
</div>

<a href="{{ route('organizer.sesiones.all') }}" class="flex px-4 py-2 text-sm rounded items-center gap-2 {{ request()->routeIs('organizer.sesiones.all') ? $activeClass : $inactiveClass }}">
    <x-heroicon-o-calendar class="w-5 h-5" />
    Sesiones
</a>

<div class="mt-4 mb-2 px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">
    Gestión de Certificados
</div>

<a href="{{ route('organizer.certificados.create') }}" class="flex px-4 py-2 text-sm rounded items-center gap-2 {{ request()->routeIs('organizer.certificados.create') ? $activeClass : $inactiveClass }}">
    <x-heroicon-o-document-plus class="w-5 h-5" />
    Generar Certificados
</a>

<a href="{{ route('organizer.certificados.all') }}" class="flex px-4 py-2 text-sm rounded items-center gap-2 {{ request()->routeIs('organizer.certificados.all', 'organizer.certificados.show') ? $activeClass : $inactiveClass }}">
    <x-heroicon-o-document-text class="w-5 h-5" />
    Historial Certificados
</a>

<a href="{{ route('profile.edit') }}" class="flex px-4 py-2 text-sm rounded items-center gap-2 {{ request()->routeIs('profile.edit') ? $activeClass : $inactiveClass }}">
    <x-heroicon-o-user class="w-5 h-5" />
    Mi Perfil
</a>
