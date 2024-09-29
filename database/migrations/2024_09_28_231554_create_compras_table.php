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
        Schema::create('compras', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->integer('cedula');
            $table->float('celular');
            $table->string('email');
            $table->date('fecha');
            $table->string('direccion');
            $table->string('descripcion');
            $table->decimal('total');
            $table->enum('forma_pago',['efectivo','transferencia']);
            $table->enum('estado',['pagada','credito']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compras');
    }
};
