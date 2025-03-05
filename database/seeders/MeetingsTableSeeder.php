<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MeetingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('meetings')->insert([
            [
                'organization_id' => 1, // Referencia a la organización
                'meeting_type_id' => 1, // Referencia al tipo de reunión
                'datetime' => '2025-03-01 10:00:00',
                'location' => 'Conference Room 1',
                'description' => 'Quarterly business strategy discussion.',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'created_by' => 1, // Supone que el creador es el usuario con id 1
            ],
            [
                'organization_id' => 2,
                'meeting_type_id' => 2,
                'datetime' => '2025-03-02 14:00:00',
                'location' => 'Room 305',
                'description' => 'Monthly team project update meeting.',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'created_by' => 1, // Supone que el creador es el usuario con id 2
            ],
        ]);
    }
}
