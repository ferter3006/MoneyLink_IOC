<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateInvitacionsTable
 * Para la migración de la tabla invitacions
 * @author Lluís Ferrater
 * @version 1.0
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('invitacions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_invitador_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('user_invitado_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('sala_id')->constrained('salas')->onDelete('cascade');
            $table->timestamps();
            $table->unique(['user_invitado_id', 'sala_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invitaciones');
    }
};
