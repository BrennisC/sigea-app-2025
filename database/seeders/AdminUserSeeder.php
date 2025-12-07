<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Rol;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear usuario administrador
        $admin = User::updateOrCreate(
            ['email' => 'admin@sigea.com'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('admin123'),
                'email_verified_at' => now(),
                'activo' => true,
            ]
        );

        // Asignar rol de ADMINISTRADOR
        $rolAdmin = Rol::where('nombre_rol', 'ADMINISTRADOR')->first();
        
        if ($rolAdmin) {
            // Sincronizar roles (evita duplicados)
            $admin->roles()->syncWithoutDetaching([$rolAdmin->id]);
        }

        $this->command->info('Usuario administrador creado: admin@sigea.com / admin123');
    }
}
