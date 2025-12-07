<?php

namespace Database\Seeders;

use App\Models\Rol;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'nombre_rol' => 'PARTICIPANTE',
                'descripcion' => 'Usuario que se inscribe en actividades y recibe certificados',
                'activo' => true,
            ],
            [
                'nombre_rol' => 'ORGANIZADOR',
                'descripcion' => 'Usuario que crea y gestiona actividades, sesiones y certificados',
                'activo' => true,
            ],
            [
                'nombre_rol' => 'ADMINISTRADOR',
                'descripcion' => 'Usuario con acceso completo al sistema',
                'activo' => true,
            ],
        ];

        foreach ($roles as $rol) {
            Rol::firstOrCreate(
                ['nombre_rol' => $rol['nombre_rol']],
                $rol
            );
        }

        $this->command->info('Roles creados exitosamente');
    }
}
