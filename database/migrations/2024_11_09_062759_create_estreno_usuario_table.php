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
        Schema::create('estreno_usuario', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('estreno_id');
            $table->unsignedBigInteger('usuario_id');
            $table->foreign('estreno_id')->references('id')->on('estrenos')->onDelete('cascade');
            $table->foreign('usuario_id')->references('id')->on('usuarios')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estreno_usuario');
    }
};
