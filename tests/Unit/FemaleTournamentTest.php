<?php

namespace Tests\Unit;

use Mockery;
use App\Models\Player;
use App\Models\Skill;
use App\Services\FemaleTournament;
use Illuminate\Support\Collection;
use PHPUnit\Framework\TestCase;

class FemaleTournamentTest extends TestCase
{
    protected $tournament;

    public function __construct(string $name)
    {
        parent::__construct($name);
        $this->tournament = new class extends FemaleTournament {
            public function testPlayRound(Collection $players): Collection
            {
                return $this->playRound($players);
            }

            public function testCalculatePlayerScore($player): int
            {
                return $this->calculatePlayerScore($player);
            }
        };
    }

    /**
     * Test the FemaleTournament::calculatePlayerScore method.
     *
     * @return void
     */
    public function test_calculate_player_score_returns_expected_score()
    {
        $player = Mockery::mock(Player::class);
        $player->shouldReceive('getSkillScore')->with(Skill::REACTION_TIME)->andReturn(500);
        $player->shouldReceive('getAttribute')->with('skill_level')->andReturn(80);

        /** @var int player score */
        $score = $this->tournament->testCalculatePlayerScore($player);

        $this->assertEquals(16, $score);
    }

    /**
     * Test the playRound parent method.
     *
     * @return void
     */
    public function test_play_round_returns_four_players()
    {
        $players = collect(range(1, 8))->map(function ($item) {
            $player = Mockery::mock(Player::class);
            $player->shouldReceive('getSkillScore')->with(Skill::REACTION_TIME)->andReturn(mt_rand(100, 1000));
            $player->shouldReceive('getAttribute')->with('skill_level')->andReturn(mt_rand(1, 100));
            $player->shouldReceive('is')->withAnyArgs()->andReturn($item % 2 !== 0);

            return $player;
        });

        $this->assertEquals(4, $this->tournament->testPlayRound($players)->count());
    }
}
