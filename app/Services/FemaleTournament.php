<?php

namespace App\Services;

use App\Models\Player;
use App\Models\Skill;

class FemaleTournament extends TournamentService
{
    /**
     * Calculate the score of all player's skills.
     *
     * @return int
     */
    protected function calculatePlayerScore(Player $player): int
    {
        /** @var int reaction time skill */
        $reactionTime = $player->getSkillScore(Skill::REACTION_TIME);

        // calculate the player skills score
        return $player->skill_level + $reactionTime;
    }
}
