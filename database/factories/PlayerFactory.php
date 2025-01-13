<?php

namespace Database\Factories;

use App\Models\Gender;
use App\Models\Player;
use App\Models\Skill;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Player>
 */
class PlayerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fn(array $attributes) => fake()->unique()->name(
                $attributes['gender_id'] === Gender::MALE ? "male" : "female"
            ),
            'skill_level' => fake()->numberBetween(1, 100),
        ];
    }

    /**
     * Creates a female player with random skill scores.
     *
     * @return static
     */
    public function female(): static
    {
        return $this->state([
            'gender_id' => Gender::FEMALE,
        ])->afterCreating(function (Player $player) {
            $player->skills()->attach(
                Skill::REACTION_TIME,
                ['score' => fake()->numberBetween(100, 1000)],
            );
        });
    }

    /**
     * Creates a male player with random skill scores.
     *
     * @return static
     */
    public function male(): static
    {
        return $this->state([
            'gender_id' => Gender::MALE,
        ])->afterCreating(function (Player $player) {
            $player->skills()->attach([
                Skill::STRENGTH => ['score' => fake()->numberBetween(100, 300)],
                Skill::SPEED => ['score' => fake()->numberBetween(5, 10)],
            ]);
        });
    }
}
