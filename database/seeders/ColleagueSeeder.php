<?php

namespace Database\Seeders;

use App\Models\Colleague;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ColleagueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed data for office_id = 1 (50 records)
        Colleague::factory()->count(50)->create(['office_id' => 1]);

        // Seed data for office_id = 2 (20 records)
        Colleague::factory()->count(20)->create(['office_id' => 2]);
    }
}
