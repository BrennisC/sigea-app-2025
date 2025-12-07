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
        Schema::create('pagos', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('inscripcion_id')->constrained('inscripciones')->onDelete('cascade');
            $table->foreignUuid('metodo_pago_id')->nullable()->constrained('metodos_pago')->onDelete('set null');
            $table->foreignUuid('estado_id')->nullable()->constrained('estados')->onDelete('set null');
            $table->decimal('monto', 10, 2);
            $table->date('fecha_pago');
            $table->string('numero_transaccion')->nullable();
            $table->string('comprobante_url')->nullable();
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};
