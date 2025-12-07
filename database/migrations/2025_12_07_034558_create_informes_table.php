<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('informes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('actividad_id')->constrained('actividades')->onDelete('cascade');
            $table->foreignUuid('user_id')->constrained('users')->onDelete('cascade'); // Quien sube el informe
            $table->string('titulo');
            $table->text('descripcion')->nullable();
            $table->string('archivo_url');
            $table->string('tipo_archivo', 50)->nullable(); // 'pdf', 'docx', etc.
            $table->date('fecha_subida');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('informes');
    }
};
