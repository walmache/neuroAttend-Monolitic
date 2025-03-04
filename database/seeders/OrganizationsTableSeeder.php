<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrganizationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('organizations')->insert([
            [
                'name' => 'Tech Innovators',
                'address' => '1234 Tech Park, Silicon Valley, CA',
                'representative' => 'John Doe',
                'phone' => '123-456-7890',
                'email' => 'contact@techinnovators.com',
                'notes' => 'A leading company in tech innovation.',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'created_by' => 1,  // Assuming user with id 1 is the creator
            ],
            [
                'name' => 'HealthCare Solutions',
                'address' => '789 Health St, Chicago, IL',
                'representative' => 'Jane Smith',
                'phone' => '987-654-3210',
                'email' => 'support@healthcaresolutions.com',
                'notes' => 'Providing healthcare solutions worldwide.',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'created_by' => 1,  // Assuming user with id 2 is the creator
            ],
        ]);
    }
}
