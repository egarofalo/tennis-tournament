<?php

namespace App\Services;

use App\Models\Gender;
use App\Models\Player;
use App\Models\Skill;
use App\Models\Tournament;
use Illuminate\Support\Arr;

class MaleTournament extends TournamentService
{
    /**
     * Create new male players and associate them to the Torunament model.
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
                    'gender_id' => Gender::MALE
                ]);

                $playerModel->skills()->attach([
                    Skill::STRENGTH => [
                        'score' => Arr::get($player, 'male_skills.strength')
                    ],
                    Skill::SPEED => [
                        'score' => Arr::get($player, 'male_skills.speed')
                    ]
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
        /** @var int strength skill */
        $strength = $player->getSkillScore(Skill::STRENGTH);

        /** @var int speed skill */
        $speed = $player->getSkillScore(Skill::SPEED);

        // strength increase factor (between 1 and 2)
        $strengthIncreaseFactor = (($strength - 100) / 200) + 1;

        // calculate the player skills score
        return round($player->skill_level * $strengthIncreaseFactor) + ($speed * 5);
    }
}
