<?php

namespace Tests\Feature;

use App\Models\Gender;
use App\Models\Tournament;
use Database\Seeders\GenderSeeder;
use Database\Seeders\SkillSeeder;
use Database\Seeders\SkillUnitSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class TournamentEndpointsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that the tournament.index endpoint returns a successful response with the expected json format.
     * 
     * @return void
     */
    public function test_index_endpoint_returns_successful_response(): void
    {
        $this->seed();

        $response = $this->getJson('/api/tournaments');

        $response->assertOk()->assertJsonIsArray('data');
    }

    /**
     * Test that the tournament.show endpoint returns a successful response with the expected json format.
     * 
     * @return void
     */
    public function test_show_endpoint_returns_successful_response(): void
    {
        $this->seed();

        $femaleTournament = Tournament::factory()->female(4)->state([
            'name' => 'Bs As Open Femenino',
        ])->create();

        $response = $this->getJson("/api/tournaments/{$femaleTournament->id}");

        $response->assertOk()->assertJsonIsObject('data')->assertJsonPath(
            'data.name',
            'Bs As Open Femenino'
        )->assertJsonIsArray('data.players');
    }

    /**
     * Returns fake data for test the tournament.post endpoint.
     *
     * @return array
     */
    protected function getMaleTournamentFakeData(): array
    {
        return [
            'gender_id' => Gender::MALE,
            'name' => 'Copa Davis 2025',
            'players' => [
                [
                    'name' => 'Roger Federer',
                    'skill_level' => 100,
                    'male_skills' => [
                        'strength' => 180,
                        'speed' => 7,
                    ]
                ],
                [
                    'name' => 'Rafael Nadal',
                    'skill_level' => 80,
                    'male_skills' => [
                        'strength' => 250,
                        'speed' => 9,
                    ]
                ],
                [
                    'name' => 'Novak Djokovic',
                    'skill_level' => 90,
                    'male_skills' => [
                        'strength' => 200,
                        'speed' => 8,
                    ]
                ],
                [
                    'name' => 'Del Potro',
                    'skill_level' => 70,
                    'male_skills' => [
                        'strength' => 290,
                        'speed' => 7,
                    ]
                ]
            ]
        ];
    }

    /**
     * Test that the tournament.store endpoint fails form request validation.
     * 
     * @return void
     */
    public function test_store_endpoint_fails_validation(): void
    {
        $this->seed([
            GenderSeeder::class,
            SkillUnitSeeder::class,
            SkillSeeder::class
        ]);

        $response = $this->postJson(
            '/api/tournaments',
            [
                ...$this->getMaleTournamentFakeData(),
                'gender_id' => 4,
            ]
        );

        $response->assertUnprocessable()->assertJsonIsObject('errors');
    }

    /**
     * Test that the tournament.store endpoint create a tournament successfully.
     *
     * @return void
     */
    public function test_store_endpoint_creates_tournament_successfully(): void
    {
        $this->seed([
            GenderSeeder::class,
            SkillUnitSeeder::class,
            SkillSeeder::class
        ]);

        $response = $this->postJson(
            '/api/tournaments',
            $this->getMaleTournamentFakeData()
        );

        $response->assertCreated()
            ->assertJsonIsObject('data')
            ->assertJsonPath('data.players', fn(array $players) => count($players) === 4);
    }
}
