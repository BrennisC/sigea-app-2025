<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use App\Models\Rol;
use Illuminate\Support\Facades\Hash;

try {
    echo "Creando usuarios de prueba...\n\n";

    // Crear Organizador
    $organizador = User::create([
        'name' => 'María Organizadora',
        'email' => 'organizador@test.com',
        'password' => Hash::make('password'),
        'telefono' => '555-1234',
        'documento_identidad' => '12345678',
        'email_verified_at' => now(),
        'activo' => true,
    ]);

    $rolOrganizador = Rol::where('nombre_rol', 'ORGANIZADOR')->first();
    if ($rolOrganizador) {
        $organizador->roles()->attach($rolOrganizador->id);
        echo "✓ Organizador creado:\n";
        echo "  Email: organizador@test.com\n";
        echo "  Password: password\n";
        echo "  Rol: ORGANIZADOR\n\n";
    }

    // Crear Participante
    $participante = User::create([
        'name' => 'Juan Participante',
        'email' => 'participante@test.com',
        'password' => Hash::make('password'),
        'telefono' => '555-5678',
        'documento_identidad' => '87654321',
        'email_verified_at' => now(),
        'activo' => true,
    ]);

    $rolParticipante = Rol::where('nombre_rol', 'PARTICIPANTE')->first();
    if ($rolParticipante) {
        $participante->roles()->attach($rolParticipante->id);
        echo "✓ Participante creado:\n";
        echo "  Email: participante@test.com\n";
        echo "  Password: password\n";
        echo "  Rol: PARTICIPANTE\n\n";
    }

    // Crear otro participante
    $participante2 = User::create([
        'name' => 'Ana Estudiante',
        'email' => 'ana@test.com',
        'password' => Hash::make('password'),
        'telefono' => '555-9999',
        'documento_identidad' => '11223344',
        'email_verified_at' => now(),
        'activo' => true,
    ]);

    if ($rolParticipante) {
        $participante2->roles()->attach($rolParticipante->id);
        echo "✓ Participante 2 creado:\n";
        echo "  Email: ana@test.com\n";
        echo "  Password: password\n";
        echo "  Rol: PARTICIPANTE\n\n";
    }

    echo "═══════════════════════════════════════════════════\n";
    echo "✅ USUARIOS DE PRUEBA CREADOS EXITOSAMENTE\n";
    echo "═══════════════════════════════════════════════════\n\n";
    
    echo "CREDENCIALES:\n\n";
    echo "Admin:\n";
    echo "  📧 admin@sigea.com\n";
    echo "  🔑 admin123\n\n";
    
    echo "Organizador:\n";
    echo "  📧 organizador@test.com\n";
    echo "  🔑 password\n\n";
    
    echo "Participantes:\n";
    echo "  📧 participante@test.com\n";
    echo "  🔑 password\n\n";
    echo "  📧 ana@test.com\n";
    echo "  🔑 password\n\n";

} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "\nDetalles:\n";
    echo $e->getTraceAsString() . "\n";
}
