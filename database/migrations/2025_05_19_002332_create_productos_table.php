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
        Schema::create('categorias', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 30);
            $table->timestamps();
        });
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 75);
            $table->tinyInteger('stock')->default(0);
            $table->decimal('costo', 10, 2)->default(0);
            $table->foreignId('categoria_id')->constrained('categorias')->onDelete('cascade');
            $table->decimal('precio', 10, 2)->default(0);
            $table->timestamps();
        });
        Schema::create('imagenes', function (Blueprint $table) {
            $table->id();
            $table->string('path', 255);
            $table->foreignId('producto_id')->constrained('productos')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
