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
        Schema::create('meetings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade'); // Usuario que creó la reunión
            $table->foreignId('organization_id')->constrained('organizations')->onDelete('cascade'); // Organización asociada
            $table->foreignId('meeting_type_id')->constrained('meeting_types')->onDelete('cascade'); // Tipo de reunión
            $table->dateTime('datetime'); // Fecha y hora de la reunión
            $table->string('location', 200)->nullable(); // Ubicación
            $table->text('description')->nullable(); // Descripción de la reunión
            $table->boolean('status')->default(1); // Estado de la reunión
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meetings');
    }
};
