<?php

namespace App\Services;

use App\Models\Player;
use App\Models\Tournament as TournamentModel;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

abstract class TournamentService implements Tournament
{
    /**
     * Creates a male or female tournament.
     *
     * @param array $data
     * @param int $genderId
     * @return TournamentModel
     */
    public function create(array $data, int $genderId): TournamentModel
    {
        return new TournamentModel($data);
    }

    /**
     * Run the tournament and returns the winner.
     * 
     * @param TournamentModel $tournament
     * @return Player
     */
    public function start(TournamentModel $tournament): Player
    {
        return transform(
            $tournament->players,
            function (Collection $players) {
                do {
                    $players = $this->playRound($players->shuffle());
                } while ($players->count() > 1);

                return $players->first();
            }
        );
    }

    /**
     * Play an elimination round.
     *
     * @param Collection $player
     * @return Collection
     */
    protected function playRound(Collection $players): Collection
    {
        return $players->chunk(2)->mapSpread(
            fn(Player $playerOne, Player $playerTwo) => $this->playMatch($playerOne, $playerTwo)
        );
    }

    /**
     * Simulate the match between two players.
     * Returns the winner.
     *
     * @param Player $playerOne
     * @param Player $playerTwo
     * @return Player
     */
    protected function playMatch(Player $playerOne, Player $playerTwo): Player
    {
        // calculate the luck factor between 1.0 and 1.5
        $luckFactor = round(mt_rand(100, 150) / 100, 1);

        /** @var Player randomly select the player to apply the luck factor */
        $luckyPlayer = Arr::random([$playerOne, $playerTwo]);

        // calculate the score for each player with the luck factor applied
        $playerOneScore = $this->calculatePlayerScore($playerOne) * ($luckyPlayer->is($playerOne) ? $luckFactor : 1);
        $playerTwoScore = $this->calculatePlayerScore($playerTwo) * ($luckyPlayer->is($playerTwo) ? $luckFactor : 1);

        return $playerOneScore === $playerTwoScore ? $luckyPlayer : (
            $playerOneScore > $playerTwoScore ? $playerOne : $playerTwo
        );
    }

    /**
     * Calculate the skills score of a player.
     * This method is used to determinate the winner of each match.
     *
     * @param Player $player
     * @return int
     */
    protected abstract function calculatePlayerScore(Player $player): int;
}
