<?php

namespace Tests\Unit;

use Mockery;
use App\Models\Player;
use App\Models\Skill;
use App\Services\MaleTournament;
use PHPUnit\Framework\TestCase;

class MaleTournamentTest extends TestCase
{
    protected $tournament;

    public function __construct(string $name)
    {
        parent::__construct($name);
        $this->tournament = new class extends MaleTournament {
            public function testCalculatePlayerScore($player): int
            {
                return $this->calculatePlayerScore($player);
            }
        };
    }

    /**
     * Test the MaleTournament::calculatePlayerScore method.
     *
     * @return void
     */
    public function test_calculate_player_score_returns_expected_score()
    {
        $player = Mockery::mock(Player::class);
        $player->shouldReceive('getSkillScore')->with(Skill::STRENGTH)->andReturn(200);
        $player->shouldReceive('getSkillScore')->with(Skill::SPEED)->andReturn(8);
        $player->shouldReceive('getAttribute')->with('skill_level')->andReturn(60);

        /** @var int player score */
        $score = $this->tournament->testCalculatePlayerScore($player);

        $this->assertEquals(130, $score);
    }
}
