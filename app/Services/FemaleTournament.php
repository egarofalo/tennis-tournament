<?php

namespace App\Services;

use App\Models\Gender;
use App\Models\Player;
use App\Models\Skill;
use App\Models\Tournament;
use Illuminate\Support\Arr;

class FemaleTournament extends TournamentService
{
    /**
     * Create new female players and associate them to the Torunament model.
     * 
     * @param Tournament $tournament
     * @param array $players players data
     */
    protected function createPlayers(Tournament $tournament, array $players): void
    {
        $tournament->players()->attach(
            Arr::map($players, function ($player) {
                $playerModel = Player::create([
                    ...Arr::only($player, ['name', 'skill_level']),
                    'gender_id' => Gender::FEMALE
                ]);

                $playerModel->skills()->attach([
                    Skill::REACTION_TIME => [
                        'score' => Arr::get($player, 'female_skills.reaction_time')
                    ],
                ]);

                return $playerModel;
            })
        );
    }

    /**
     * Calculate the score of all player's skills.
     *
     * @return int
     */
    protected function calculatePlayerScore(Player $player): int
    {
        /** @var int reaction time skill */
        $reactionTime = $player->getSkillScore(Skill::REACTION_TIME);

        // reaction time decrease factor (between 0,1 and 1)
        $reactionTimeDecreaseFactor = 100 / $reactionTime;

        // calculate the player skills score
        return round($player->skill_level * $reactionTimeDecreaseFactor);
    }
}
