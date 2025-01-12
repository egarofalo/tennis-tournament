<?php

namespace App\Services;

use Illuminate\Support\Facades\Facade;

class TournamentFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return Tournament::class;
    }
}
