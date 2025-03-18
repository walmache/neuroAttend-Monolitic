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
            // $table->integer('duration')->default(60); // Duración en minutos
            // $table->boolean('is_virtual')->default(false); // Virtual o presencial
            // $table->integer('capacity')->default(0); // 0 = ilimitado
            $table->json('custom_fields'); // Campos personalizados
            $table->boolean('remember')->default(false); // Recordatorio
            $table->decimal('fee_amount', 10, 2)->default(0.00); // Monto de pago
            $table->text('qr_code')->nullable(); // Código QR
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('meetings', function (Blueprint $table) {
            $table->dropColumn(['duration', 'is_virtual', 'capacity', 'custom_fields', 'remember', 'fee_amount', 'qr_code']);
        });
    }
};
