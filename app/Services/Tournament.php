<?php

namespace App\Services;

use App\Models\Player;
use App\Models\Tournament as TournamentModel;

interface Tournament
{
    /**
     * Creates a male or female tournament.
     *
     * @param array $data
     * @param int $genderId
     * @return TournamentModel
     */
    public function create(array $data, int $genderId): TournamentModel;

    /**
     * Starts the tournament and returns the winner.
     * 
     * @param TournamentModel $tournament
     * @return Player
     */
    public function start(TournamentModel $tournament): Player;
}
