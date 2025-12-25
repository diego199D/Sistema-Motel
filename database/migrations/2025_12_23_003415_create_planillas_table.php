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
        Schema::create('planillas', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('habitacion_id')->constrained('habitacions');
            $table->date('fecha');
            $table->datetime('entrada');
            $table->datetime('salida')->nullable();
            $table->decimal('pago_adelantado', 8, 2)->default(0);
            $table->boolean('ac')->default(false);
            $table->decimal('monto_habitacion', 8, 2)->default(0)->nullable();
            $table->decimal('monto_consumo', 8, 2)->default(0)->nullable();
            $table->decimal('monto_total', 8, 2)->default(0)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('planillas');
    }
};
