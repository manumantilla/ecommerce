<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('producto', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_categoria')->constrained('categoria')->onDelete('cascade');
            $table->string('nombre');
            $table->string('descripcion');
            $table->string('cantidad');
            $table->float('precio');
            $table->float('precio_al_por_mayor');
            $table->date('fecha_vencimiento');
            $table->string('ubicacion');
            $table->string('imagen');
            $table->foreignId('id_proveedor')->constrained('proveedor')->onDelete('cascade');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('producto');
    }
};
