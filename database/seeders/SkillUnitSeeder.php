<?php

namespace Database\Seeders;

use App\Models\SkillUnit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SkillUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SkillUnit::create([
            'id' => SkillUnit::METERS_PER_SECOND,
            'name' => 'Metros por segundo',
            'symbol' => 'm/s',
        ]);

        SkillUnit::create([
            'id' => SkillUnit::KM_PER_HOUR,
            'name' => 'Kilometros por hora',
            'symbol' => 'km/h',
        ]);

        SkillUnit::create([
            'id' => SkillUnit::SECONDS,
            'name' => 'Segundos',
            'symbol' => 's',
        ]);
    }
}
