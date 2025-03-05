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
            $table->foreignId('meeting_id')->constrained('meetings')->onDelete('cascade'); // Reunión asociada
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Usuario que asiste
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade'); // Usuario que registró la asistencia
            $table->boolean('attended')->default(0); // Indica si asistió o no
            $table->longText('signature')->nullable(); // Firma en base64
            $table->text('notes')->nullable(); // Notas adicionales
            $table->boolean('status')->default(1); // Estado de la asistencia
            $table->timestamps();
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
