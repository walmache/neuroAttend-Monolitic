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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('meeting_id'); // Relación con reunión
            $table->unsignedBigInteger('user_id');    // Relación con usuario
            $table->unsignedBigInteger('created_by'); // Relación con usuario que crea la asistencia
            $table->boolean('attended')->default(true); // Asistió o no
            $table->text('notes')->nullable(); // Observaciones
            $table->smallInteger('status')->default(1); // Estado de la asistencia
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
    
            // Relaciones
            $table->foreign('meeting_id')->references('id')->on('meetings');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('created_by')->references('id')->on('users');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
