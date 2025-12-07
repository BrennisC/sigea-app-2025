<?php

use App\Http\Controllers\Admin\CatalogoController as AdminCatalogoController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\CertificateValidationController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\Organizer\ActivityController as OrganizerActivityController;
use App\Http\Controllers\Organizer\AttendanceController;
use App\Http\Controllers\Organizer\CertificateController as OrganizerCertificateController;
use App\Http\Controllers\Organizer\DashboardController as OrganizerDashboardController;
use App\Http\Controllers\Organizer\SessionController;
use App\Http\Controllers\Participant\CertificateController as ParticipantCertificateController;
use App\Http\Controllers\Participant\DashboardController as ParticipantDashboardController;
use App\Http\Controllers\Participant\EnrollmentController;
use App\Http\Controllers\Participant\ProfileController;
use App\Http\Controllers\PublicActivityController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rutas Públicas
|--------------------------------------------------------------------------
*/

// Landing page
Route::get('/', [LandingController::class, 'index'])->name('landing');

// Actividades públicas
Route::get('/actividades', [PublicActivityController::class, 'index'])->name('actividades.index');
Route::get('/actividades/{id}', [PublicActivityController::class, 'show'])->name('actividades.show');

// Validación de certificados
Route::get('/certificados/validar', [CertificateValidationController::class, 'showForm'])->name('certificados.validar.form');
Route::post('/certificados/validar', [CertificateValidationController::class, 'validate'])->name('certificados.validar');

/*
|--------------------------------------------------------------------------
| Rutas de Autenticación (Breeze)
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';

// Rutas de perfil de Breeze (compatibilidad)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Dashboard dinámico según rol
Route::get('/dashboard', function () {
    $user = auth()->user();
    
    if ($user->tieneRol('ADMINISTRADOR')) {
        return redirect()->route('admin.dashboard');
    } elseif ($user->tieneRol('ORGANIZADOR')) {
        return redirect()->route('organizer.dashboard');
    } else {
        return redirect()->route('participant.dashboard');
    }
})->middleware(['auth', 'verified'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| Rutas para PARTICIPANTE
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified', 'role:PARTICIPANTE,ORGANIZADOR,ADMINISTRADOR'])->group(function () {
    // Dashboard participante
    Route::get('/panel', [ParticipantDashboardController::class, 'index'])->name('participant.dashboard');
    
    // Mis actividades / inscripciones
    Route::get('/mis-actividades', [EnrollmentController::class, 'index'])->name('participant.actividades.index');
    Route::get('/inscripciones', [EnrollmentController::class, 'index'])->name('participant.enrollments.index');
    Route::post('/inscripciones', [EnrollmentController::class, 'store'])->name('participant.enrollments.store');
    
    // Mis certificados
    Route::get('/mis-certificados', [ParticipantCertificateController::class, 'index'])->name('participant.certificates.index');
    Route::get('/certificados/{id}/descargar', [ParticipantCertificateController::class, 'download'])->name('participant.certificates.download');
    
    // Perfil
    Route::get('/perfil', [ProfileController::class, 'edit'])->name('participant.profile.edit');
    Route::put('/perfil', [ProfileController::class, 'update'])->name('participant.profile.update');
});

/*
|--------------------------------------------------------------------------
| Rutas para ORGANIZADOR
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified', 'role:ORGANIZADOR,ADMINISTRADOR'])->prefix('organizador')->name('organizer.')->group(function () {
    // Dashboard organizador
    Route::get('/', [OrganizerDashboardController::class, 'index'])->name('dashboard');
    
    // Gestión de actividades
    Route::resource('actividades', OrganizerActivityController::class);
    
    // Inscripciones de una actividad
    Route::get('actividades/{id}/inscripciones', [OrganizerActivityController::class, 'enrollments'])->name('actividades.enrollments');
    
    // Sesiones
    Route::get('sesiones', [SessionController::class, 'indexAll'])->name('sesiones.all');
    Route::get('actividades/{activityId}/sesiones', [SessionController::class, 'index'])->name('sesiones.index');
    Route::get('actividades/{activityId}/sesiones/crear', [SessionController::class, 'create'])->name('sesiones.create');
    Route::post('actividades/{activityId}/sesiones', [SessionController::class, 'store'])->name('sesiones.store');
    Route::get('sesiones/{id}/editar', [SessionController::class, 'edit'])->name('sesiones.edit');
    Route::put('sesiones/{id}', [SessionController::class, 'update'])->name('sesiones.update');
    Route::delete('sesiones/{id}', [SessionController::class, 'destroy'])->name('sesiones.destroy');
    
    // Asistencias
    Route::get('asistencias', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::get('sesiones/{id}/asistencias', [AttendanceController::class, 'show'])->name('asistencias.show');
    Route::post('sesiones/{id}/asistencias', [AttendanceController::class, 'store'])->name('asistencias.store');
    
    // Generación de certificados
    Route::post('certificados/generar', [OrganizerCertificateController::class, 'generate'])->name('certificados.generate');
    Route::get('certificados/crear', [OrganizerCertificateController::class, 'create'])->name('certificados.create');
    Route::get('certificados/todos', [OrganizerCertificateController::class, 'indexAll'])->name('certificados.all');
    Route::get('certificados/{id}', [OrganizerCertificateController::class, 'show'])->name('certificados.show');
    Route::get('actividades/{id}/certificados', [OrganizerCertificateController::class, 'index'])->name('certificados.index');
});

/*
|--------------------------------------------------------------------------
| Rutas para ADMINISTRADOR
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified', 'role:ADMINISTRADOR'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard admin
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Gestión de usuarios
    Route::get('usuarios', [AdminUserController::class, 'index'])->name('usuarios.index');
    Route::get('usuarios/{id}', [AdminUserController::class, 'show'])->name('usuarios.show');
    Route::patch('usuarios/{id}/roles', [AdminUserController::class, 'updateRoles'])->name('usuarios.roles.update');
    Route::patch('usuarios/{id}/estado', [AdminUserController::class, 'toggleStatus'])->name('usuarios.estado.toggle');
    
    // Gestión de catálogos
    Route::get('catalogos', [AdminCatalogoController::class, 'index'])->name('catalogos.index');
    Route::post('catalogos/{tipo}', [AdminCatalogoController::class, 'store'])->name('catalogos.store');
    Route::put('catalogos/{tipo}/{id}', [AdminCatalogoController::class, 'update'])->name('catalogos.update');
    Route::delete('catalogos/{tipo}/{id}', [AdminCatalogoController::class, 'destroy'])->name('catalogos.destroy');
    
    // Reportes
    Route::get('reportes', [AdminDashboardController::class, 'reports'])->name('reportes');
});
