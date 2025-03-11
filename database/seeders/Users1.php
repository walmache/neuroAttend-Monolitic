<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class Users1 extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $organizations = [1, 2, 3]; // Organizaciones permitidas
        $roles = [1, 2, 3, 4]; // Roles permitidos

        foreach ($organizations as $org) {
            for ($i = 1; $i <= 15; $i++) {
                DB::table('users')->insert([
                    'organization_id' => $org,
                    'role_id' => $roles[array_rand($roles)], // Asigna un rol aleatorio
                    'name' => fake()->name(),
                    'identification' => Str::random(10), // Simula una cédula o DNI
                    'email' => fake()->unique()->safeEmail(),
                    'phone' => fake()->phoneNumber(),
                    'photo' => fake()->imageUrl(200, 200, 'people'), // Foto de prueba
                    'status' => 1, // Activo
                    'created_by' => 1, // Supongamos que el admin los crea
                    'login' => fake()->userName(),
                    'password' => Hash::make('password'), // Contraseña predeterminada
                    'email_verified_at' => now(),
                    'remember_token' => Str::random(10),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
