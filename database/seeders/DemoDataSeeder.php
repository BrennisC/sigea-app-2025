<?php

namespace Database\Seeders;

use App\Models\Actividad;
use App\Models\Certificado;
use App\Models\Estado;
use App\Models\Inscripcion;
use App\Models\Rol;
use App\Models\Sesion;
use App\Models\Tipo;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoDataSeeder extends Seeder
{
    /**
     * Seed de datos de demostración completos
     */
    public function run(): void
    {
        $this->command->info('Creando usuarios de prueba...');
        
        // Crear usuarios de prueba
        $organizador = User::updateOrCreate(
            ['email' => 'organizador@test.com'],
            [
                'name' => 'María Organizadora',
                'password' => Hash::make('password'),
                'telefono' => '555-1234',
                'documento_identidad' => '12345678',
                'direccion' => 'Av. Principal 123',
                'email_verified_at' => now(),
                'activo' => true,
            ]
        );
        
        $rolOrganizador = Rol::where('nombre_rol', 'ORGANIZADOR')->first();
        if (!$organizador->roles->contains($rolOrganizador->id)) {
            $organizador->roles()->attach($rolOrganizador->id);
        }

        $participante1 = User::updateOrCreate(
            ['email' => 'participante@test.com'],
            [
                'name' => 'Juan Participante',
                'password' => Hash::make('password'),
                'telefono' => '555-5678',
                'documento_identidad' => '87654321',
                'direccion' => 'Calle Secundaria 456',
                'email_verified_at' => now(),
                'activo' => true,
            ]
        );

        $participante2 = User::updateOrCreate(
            ['email' => 'ana@test.com'],
            [
                'name' => 'Ana Estudiante',
                'password' => Hash::make('password'),
                'telefono' => '555-9999',
                'documento_identidad' => '11223344',
                'direccion' => 'Jr. Los Olivos 789',
                'email_verified_at' => now(),
                'activo' => true,
            ]
        );

        $rolParticipante = Rol::where('nombre_rol', 'PARTICIPANTE')->first();
        if (!$participante1->roles->contains($rolParticipante->id)) {
            $participante1->roles()->attach($rolParticipante->id);
        }
        if (!$participante2->roles->contains($rolParticipante->id)) {
            $participante2->roles()->attach($rolParticipante->id);
        }

        $this->command->info('Creando actividades de demostración...');

        // Obtener estados y tipos
        $estadoPublicada = Estado::where('nombre', 'Publicada')->where('tipo', 'actividad')->first();
        $estadoEnCurso = Estado::where('nombre', 'En Curso')->where('tipo', 'actividad')->first();
        $estadoFinalizada = Estado::where('nombre', 'Finalizada')->where('tipo', 'actividad')->first();
        
        $tipoTaller = Tipo::where('nombre', 'Taller')->first();
        $tipoCurso = Tipo::where('nombre', 'Curso')->first();
        $tipoCharla = Tipo::where('nombre', 'Charla')->first();

        // Crear actividades
        $actividad1 = Actividad::create([
            'organizador_id' => $organizador->id,
            'tipo_id' => $tipoTaller->id,
            'estado_id' => $estadoPublicada->id,
            'nombre' => 'Taller de Laravel Avanzado',
            'descripcion' => 'Aprende técnicas avanzadas de Laravel incluyendo Eloquent, Jobs, Events y más.',
            'fecha_inicio' => now()->addDays(7),
            'fecha_fin' => now()->addDays(14),
            'modalidad' => 'virtual',
            'url_virtual' => 'https://zoom.us/j/123456789',
            'precio' => 150.00,
            'cupo_maximo' => 30,
            'horas_totales' => 20,
            'porcentaje_asistencia_minima' => 80,
            'requiere_pago' => true,
            'activo' => true,
        ]);

        $actividad2 = Actividad::create([
            'organizador_id' => $organizador->id,
            'tipo_id' => $tipoCurso->id,
            'estado_id' => $estadoEnCurso->id,
            'nombre' => 'Curso de Vue.js para Principiantes',
            'descripcion' => 'Introducción completa a Vue.js 3, desde cero hasta proyectos reales.',
            'fecha_inicio' => now()->subDays(3),
            'fecha_fin' => now()->addDays(25),
            'modalidad' => 'hibrida',
            'ubicacion' => 'Auditorio Central',
            'url_virtual' => 'https://meet.google.com/abc-defg-hij',
            'precio' => 0,
            'cupo_maximo' => 50,
            'horas_totales' => 30,
            'porcentaje_asistencia_minima' => 75,
            'requiere_pago' => false,
            'activo' => true,
        ]);

        $actividad3 = Actividad::create([
            'organizador_id' => $organizador->id,
            'tipo_id' => $tipoCharla->id,
            'estado_id' => $estadoFinalizada->id,
            'nombre' => 'Charla: Tendencias en Desarrollo Web 2025',
            'descripcion' => 'Descubre las últimas tendencias y tecnologías en desarrollo web.',
            'fecha_inicio' => now()->subDays(30),
            'fecha_fin' => now()->subDays(30),
            'modalidad' => 'presencial',
            'ubicacion' => 'Sala de Conferencias A',
            'precio' => 0,
            'cupo_maximo' => 100,
            'horas_totales' => 3,
            'porcentaje_asistencia_minima' => 100,
            'requiere_pago' => false,
            'activo' => true,
        ]);

        $this->command->info('Creando sesiones...');

        // Crear sesiones para actividad 1
        Sesion::create([
            'actividad_id' => $actividad1->id,
            'nombre' => 'Introducción a Laravel',
            'descripcion' => 'Conceptos básicos y arquitectura MVC',
            'fecha_hora_inicio' => now()->addDays(7)->setTime(18, 0),
            'fecha_hora_fin' => now()->addDays(7)->setTime(20, 0),
            'duracion_minutos' => 120,
            'url_virtual' => 'https://zoom.us/j/123456789',
            'instructor' => 'María Organizadora',
            'asistencia_tomada' => false,
        ]);

        Sesion::create([
            'actividad_id' => $actividad1->id,
            'nombre' => 'Eloquent ORM Avanzado',
            'descripcion' => 'Relaciones, scopes y query optimization',
            'fecha_hora_inicio' => now()->addDays(9)->setTime(18, 0),
            'fecha_hora_fin' => now()->addDays(9)->setTime(20, 0),
            'duracion_minutos' => 120,
            'url_virtual' => 'https://zoom.us/j/123456789',
            'instructor' => 'María Organizadora',
            'asistencia_tomada' => false,
        ]);

        // Crear sesiones para actividad 2
        $sesion1 = Sesion::create([
            'actividad_id' => $actividad2->id,
            'nombre' => 'Fundamentos de Vue.js',
            'descripcion' => 'Componentes, directivas y reactividad',
            'fecha_hora_inicio' => now()->subDays(2)->setTime(19, 0),
            'fecha_hora_fin' => now()->subDays(2)->setTime(21, 0),
            'duracion_minutos' => 120,
            'ubicacion' => 'Auditorio Central',
            'instructor' => 'María Organizadora',
            'asistencia_tomada' => true,
        ]);

        $this->command->info('Creando inscripciones...');

        // Crear inscripciones
        $estadoConfirmada = Estado::where('nombre', 'Confirmada')->where('tipo', 'inscripcion')->first();
        
        $inscripcion1 = Inscripcion::create([
            'user_id' => $participante1->id,
            'actividad_id' => $actividad2->id,
            'estado_id' => $estadoConfirmada->id,
            'fecha_inscripcion' => now()->subDays(5),
            'pago_requerido' => false,
            'pago_completado' => false,
        ]);

        $inscripcion2 = Inscripcion::create([
            'user_id' => $participante2->id,
            'actividad_id' => $actividad2->id,
            'estado_id' => $estadoConfirmada->id,
            'fecha_inscripcion' => now()->subDays(4),
            'pago_requerido' => false,
            'pago_completado' => false,
        ]);

        // Inscripción en actividad finalizada
        $inscripcion3 = Inscripcion::create([
            'user_id' => $participante1->id,
            'actividad_id' => $actividad3->id,
            'estado_id' => $estadoConfirmada->id,
            'fecha_inscripcion' => now()->subDays(35),
            'pago_requerido' => false,
            'pago_completado' => false,
        ]);

        $this->command->info('Creando certificado de demostración...');

        // Crear certificado para la actividad finalizada
        Certificado::create([
            'inscripcion_id' => $inscripcion3->id,
            'actividad_id' => $actividad3->id,
            'user_id' => $participante1->id,
            'fecha_emision' => now()->subDays(29),
            'porcentaje_asistencia' => 100,
            'horas_certificadas' => 3,
            'generado_por' => $organizador->id,
            'activo' => true,
        ]);

        $this->command->info('✅ Datos de demostración creados exitosamente!');
        $this->command->info('');
        $this->command->info('═══════════════════════════════════════════════════');
        $this->command->info('CREDENCIALES DE ACCESO:');
        $this->command->info('═══════════════════════════════════════════════════');
        $this->command->info('');
        $this->command->info('Admin:');
        $this->command->info('  📧 admin@sigea.com');
        $this->command->info('  🔑 admin123');
        $this->command->info('');
        $this->command->info('Organizador:');
        $this->command->info('  📧 organizador@test.com');
        $this->command->info('  🔑 password');
        $this->command->info('  ✓ 3 actividades creadas');
        $this->command->info('');
        $this->command->info('Participantes:');
        $this->command->info('  📧 participante@test.com');
        $this->command->info('  🔑 password');
        $this->command->info('  ✓ 2 inscripciones, 1 certificado');
        $this->command->info('');
        $this->command->info('  📧 ana@test.com');
        $this->command->info('  🔑 password');
        $this->command->info('  ✓ 1 inscripción');
        $this->command->info('');
        $this->command->info('═══════════════════════════════════════════════════');
    }
}
