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
     * @param bool $start if true the tournament is run after it is created.
     * @return TournamentModel
     */
    public function create(array $data, bool $start = false): TournamentModel;

    /**
     * Starts the tournament and returns the winner.
     * 
     * @param TournamentModel $tournament
     * @return Player
     */
    public function start(TournamentModel $tournament): Player;
}
