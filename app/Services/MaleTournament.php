<?php

namespace App\Services;

use App\Models\Player;
use App\Models\Skill;

class MaleTournament extends TournamentService
{
    /**
     * Calculate the score of all player's skills.
     *
     * @return int
     */
    protected function calculatePlayerScore(Player $player): int
    {
        /** @var int strength skill */
        $strength = $player->getSkillScore(Skill::STRENGTH);

        /** @var int speed skill */
        $speed = $player->getSkillScore(Skill::SPEED);

        // calculate the player skills score
        return $player->skill_level + $strength + $speed;
    }
}
