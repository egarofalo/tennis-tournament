<?php

namespace Tests\Feature;

use App\Models\Player;
use Database\Seeders\GenderSeeder;
use Database\Seeders\SkillSeeder;
use Database\Seeders\SkillUnitSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PlayerEndpointsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that the players.index endpoint returns a successful response with the expected json format.
     * 
     * @return void
     */
    public function test_index_endpoint_returns_successful_response(): void
    {
        $this->seed();

        $response = $this->getJson('/api/players');

        $response->assertOk()->assertJsonIsArray('data');
    }

    /**
     * Test that the players.show endpoint returns a successful response with the expected json format.
     * 
     * @return void
     */
    public function test_show_endpoint_returns_successful_response(): void
    {
        $this->seed([
            GenderSeeder::class,
            SkillUnitSeeder::class,
            SkillSeeder::class,
        ]);

        $malePlayer = Player::factory()->male()->state([
            'name' => 'Roger Federer'
        ])->create();

        $response = $this->getJson("/api/players/{$malePlayer->id}");

        $response->assertOk()->assertJsonIsObject(
            'data'
        )->assertJsonPath('data.name', 'Roger Federer');
    }
}
