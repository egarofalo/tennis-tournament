<?php

namespace Database\Factories;

use App\Models\Gender;
use App\Models\Player;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tournament>
 */
class TournamentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fn(array $attributes) => Str::of(fake()->unique()->city)->append(
                $attributes['gender_id'] === Gender::FEMALE ? ' Female' : ' Male',
                ' Tournament'
            )->value(),
            'gender_id' => fake()->randomElement([
                Gender::FEMALE,
                Gender::MALE
            ])
        ];
    }

    /**
     * Create tournament with male players.
     * 
     * @param int $playersCount
     * @return static
     */
    public function male(int $playersCount): static
    {
        return $this->state(
            ['gender_id' => Gender::MALE]
        )->has(Player::factory()->male()->count($playersCount));
    }

    /**
     * Create tournament with female players.
     * 
     * @param int $playersCount
     * @return static
     */
    public function female(int $playersCount): static
    {
        return $this->state(
            ['gender_id' => Gender::FEMALE]
        )->has(Player::factory()->female()->count($playersCount));
    }
}
