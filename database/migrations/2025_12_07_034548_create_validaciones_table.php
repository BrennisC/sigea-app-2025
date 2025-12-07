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
        Schema::create('validaciones', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('certificado_id')->constrained('certificados')->onDelete('cascade');
            $table->string('ip_address', 45)->nullable();
            $table->dateTime('fecha_hora_validacion');
            $table->string('user_agent')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('validaciones');
    }
};
