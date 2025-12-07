<?php

namespace Database\Seeders;

use App\Models\Estado;
use App\Models\Tipo;
use App\Models\MetodoPago;
use Illuminate\Database\Seeder;

class CatalogoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Estados para actividades
        $estadosActividad = [
            ['nombre' => 'Planificada', 'descripcion' => 'Actividad en planificación', 'tipo' => 'actividad'],
            ['nombre' => 'Publicada', 'descripcion' => 'Actividad publicada y abierta a inscripciones', 'tipo' => 'actividad'],
            ['nombre' => 'En Curso', 'descripcion' => 'Actividad en desarrollo', 'tipo' => 'actividad'],
            ['nombre' => 'Finalizada', 'descripcion' => 'Actividad completada', 'tipo' => 'actividad'],
            ['nombre' => 'Cancelada', 'descripcion' => 'Actividad cancelada', 'tipo' => 'actividad'],
        ];

        // Estados para inscripciones
        $estadosInscripcion = [
            ['nombre' => 'Pendiente', 'descripcion' => 'Inscripción pendiente de confirmación', 'tipo' => 'inscripcion'],
            ['nombre' => 'Confirmada', 'descripcion' => 'Inscripción confirmada', 'tipo' => 'inscripcion'],
            ['nombre' => 'Cancelada', 'descripcion' => 'Inscripción cancelada', 'tipo' => 'inscripcion'],
        ];

        // Estados para pagos
        $estadosPago = [
            ['nombre' => 'Pendiente', 'descripcion' => 'Pago pendiente', 'tipo' => 'pago'],
            ['nombre' => 'Aprobado', 'descripcion' => 'Pago aprobado', 'tipo' => 'pago'],
            ['nombre' => 'Rechazado', 'descripcion' => 'Pago rechazado', 'tipo' => 'pago'],
        ];

        // Estados para certificados
        $estadosCertificado = [
            ['nombre' => 'Generado', 'descripcion' => 'Certificado generado', 'tipo' => 'certificado'],
            ['nombre' => 'Revocado', 'descripcion' => 'Certificado revocado', 'tipo' => 'certificado'],
        ];

        $todosEstados = array_merge($estadosActividad, $estadosInscripcion, $estadosPago, $estadosCertificado);

        foreach ($todosEstados as $estado) {
            Estado::firstOrCreate(
                ['nombre' => $estado['nombre'], 'tipo' => $estado['tipo']],
                array_merge($estado, ['activo' => true])
            );
        }

        // Tipos de actividades
        $tiposActividad = [
            ['nombre' => 'Taller', 'descripcion' => 'Actividad práctica', 'categoria' => 'actividad'],
            ['nombre' => 'Curso', 'descripcion' => 'Curso de formación', 'categoria' => 'actividad'],
            ['nombre' => 'Charla', 'descripcion' => 'Conferencia o charla', 'categoria' => 'actividad'],
            ['nombre' => 'Seminario', 'descripcion' => 'Seminario educativo', 'categoria' => 'actividad'],
            ['nombre' => 'Capacitación', 'descripcion' => 'Capacitación profesional', 'categoria' => 'actividad'],
        ];

        foreach ($tiposActividad as $tipo) {
            Tipo::firstOrCreate(
                ['nombre' => $tipo['nombre'], 'categoria' => $tipo['categoria']],
                array_merge($tipo, ['activo' => true])
            );
        }

        // Métodos de pago
        $metodosPago = [
            ['nombre' => 'Efectivo', 'descripcion' => 'Pago en efectivo'],
            ['nombre' => 'Transferencia Bancaria', 'descripcion' => 'Transferencia bancaria'],
            ['nombre' => 'Tarjeta de Crédito', 'descripcion' => 'Pago con tarjeta de crédito'],
            ['nombre' => 'Tarjeta de Débito', 'descripcion' => 'Pago con tarjeta de débito'],
            ['nombre' => 'PayPal', 'descripcion' => 'Pago vía PayPal'],
            ['nombre' => 'Otro', 'descripcion' => 'Otro método de pago'],
        ];

        foreach ($metodosPago as $metodo) {
            MetodoPago::firstOrCreate(
                ['nombre' => $metodo['nombre']],
                array_merge($metodo, ['activo' => true])
            );
        }

        $this->command->info('Catálogos creados exitosamente');
    }
}
