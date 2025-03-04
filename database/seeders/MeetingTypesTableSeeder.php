<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MeetingTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('meeting_types')->insert([
            [
                'name' => 'Business Meeting',
                'description' => 'Official meeting for business discussions.',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'created_by' => 1,  // Assuming user with id 1 created it
            ],
            [
                'name' => 'Team Meeting',
                'description' => 'Internal meeting for team updates and planning.',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'created_by' => 1,  // Assuming user with id 2 created it
            ],
        ]);
    }
}
