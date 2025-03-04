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
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('organization_id')->nullable()->after('id');
            $table->unsignedBigInteger('role_id')->nullable()->after('organization_id');
            $table->string('identification', 20)->after('name'); // Identificación
            $table->string('phone', 20)->nullable()->after('email'); // Teléfono
            $table->string('photo', 255)->nullable()->after('phone'); // Foto
            $table->smallInteger('status')->default(1)->after('photo'); // Estado
            $table->integer('created_by')->after('status'); // Creado por
            $table->string('login', 50)->unique()->after('created_by'); // Login
            
            // Agregar claves foráneas
            $table->foreign('organization_id')->references('id')->on('organizations')->onDelete('set null');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'organization_id',
                'role_id',
                'identification',
                'phone',
                'photo',
                'status',
                'created_by',
                'username',
            ]);
        });
    }
};
