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
            'name' => 'Wilfrido Almache',
            'identification' => '1711884617',  // Puedes ajustar este dato según lo que desees
            'email' => 'walmache@gmail.com',
            'phone' => '0983142973',
            'photo' => 'default.jpg',  // Foto de usuario por defecto (ajustar según tus necesidades)
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
            'created_by' => 1,  // Asumimos que el creador tiene id 1
            'login' => 'walmache',
            'password' => Hash::make('Rtl8139$'),  // Usamos Hash::make para almacenar la contraseña de forma segura
            'organization_id' => 1,  // Asumiendo que este usuario pertenece a la organización con id 1
            'role_id' => 1,  // Asumimos que el usuario tiene el rol con id 3 (ajustar según tus necesidades)
        ]);
    }
}
