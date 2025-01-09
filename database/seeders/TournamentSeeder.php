<?php

namespace Database\Seeders;

use App\Models\Tournament;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TournamentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a female tournament with eight (8) players
        Tournament::factory()->female(8)->create();

        // Create a male tournament with eight (8) players
        Tournament::factory()->male(8)->create();
    }
}
