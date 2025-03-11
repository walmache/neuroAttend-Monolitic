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
        Schema::table('meetings', function (Blueprint $table) {
            $table->dropColumn(['date', 'time']); // Eliminar columnas separadas
            $table->dateTime('datetime')->after('meeting_type_id'); // Agregar nueva columna
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('meetings', function (Blueprint $table) {
            $table->date('date')->after('meeting_type_id');
            $table->time('time')->after('date');
            $table->dropColumn('datetime');
        });
    }
};
