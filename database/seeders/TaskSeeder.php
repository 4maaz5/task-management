<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Faker\Factory as Faker;
class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $faker = Faker::create();

        // Generate random data for 50 tasks
        for ($i = 0; $i < 20; $i++) {
            DB::table('tasks')->insert([
                'title' => $faker->sentence,
                'description' => $faker->paragraph,
                'priority' => $faker->numberBetween(1, 2), // Assuming 0: Low, 1: Medium, 2: High
                'due_date' => $faker->dateTimeBetween('+1 week', '+1 month')->format('Y-m-d H:i:s'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

