<a href="{{ route('participant.dashboard') }}" class="flex px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 rounded items-center gap-2">
    <x-heroicon-o-chart-pie class="w-5 h-5" />
    Dashboard
</a>

<a href="{{ route('participant.actividades.index') }}" class="flex px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 rounded items-center gap-2">
    <x-heroicon-o-calendar class="w-5 h-5" />
    Mis Actividades
</a>


<a href="{{ route('participant.certificates.index') }}" class="flex px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 rounded items-center gap-2">
    <x-heroicon-o-academic-cap class="w-5 h-5" />
    Mis Certificados
</a>

<a href="{{ route('participant.profile.edit') }}" class="flex px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 rounded items-center gap-2">
    <x-heroicon-o-user class="w-5 h-5" />
    Mi Perfil
</a>
