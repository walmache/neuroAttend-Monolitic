<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Usuario',
            'identification' => '1234567890',  // Puedes ajustar este dato según lo que desees
            'email' => 'usuario@dominio.com',
            'phone' => '123-456-7890',
            'photo' => 'default.jpg',  // Foto de usuario por defecto (ajustar según tus necesidades)
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
            'created_by' => 1,  // Asumimos que el creador tiene id 1
            'login' => 'usuario',
            'password' => Hash::make('123456'),  // Usamos Hash::make para almacenar la contraseña de forma segura
            'organization_id' => 1,  // Asumiendo que este usuario pertenece a la organización con id 1
            'role_id' => 3,  // Asumimos que el usuario tiene el rol con id 3 (ajustar según tus necesidades)
        ]);
    }
}
