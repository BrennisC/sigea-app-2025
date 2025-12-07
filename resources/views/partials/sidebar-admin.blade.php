<p class="px-4 text-xs text-gray-400 uppercase tracking-wider mt-4">Inicio</p>
<a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 rounded">
    <x-heroicon-o-chart-pie class="w-5 h-5" />
    Dashboard
</a>

<p class="px-4 text-xs text-gray-400 uppercase tracking-wider mt-4">Administración</p>
<a href="{{ route('admin.usuarios.index') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 rounded">
    <x-heroicon-o-users class="w-5 h-5" />
    Usuarios
</a>
<a href="{{ route('organizer.actividades.index') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 rounded">
    <x-heroicon-o-calendar class="w-5 h-5" />
    Actividades
</a>

<p class="px-4 text-xs text-gray-400 uppercase tracking-wider mt-4">Configuración</p>
<a href="{{ route('admin.catalogos.index') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 rounded">
    <x-heroicon-o-archive-box class="w-5 h-5" />
    Catálogos
</a>
<a href="{{ route('admin.reportes') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 rounded">
    <x-heroicon-o-chart-bar class="w-5 h-5" />
    Reportes
</a>
