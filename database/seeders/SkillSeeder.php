<?php

namespace Database\Seeders;

use App\Models\Gender;
use App\Models\Skill;
use App\Models\SkillUnit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Skill::create([
            'id' => Skill::STRENGTH,
            'name' => 'Fuerza',
            'unit_id' => SkillUnit::KM_PER_HOUR,
            'gender_id' => Gender::MALE,
        ]);

        Skill::create([
            'id' => Skill::SPEED,
            'name' => 'Velocidad',
            'unit_id' => SkillUnit::METERS_PER_SECOND,
            'gender_id' => Gender::MALE,
        ]);

        Skill::create([
            'id' => Skill::REACTION_TIME,
            'name' => 'Tiempo de reacción',
            'unit_id' => SkillUnit::MILISECONDS,
            'gender_id' => Gender::FEMALE,
        ]);
    }
}
