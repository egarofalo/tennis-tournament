<?php

namespace App\Providers;

use App\Exceptions\InvalidGenderIdFromRequestException;
use App\Models\Gender;
use App\Services\FemaleTournament;
use App\Services\MaleTournament;
use App\Services\Tournament;
use Illuminate\Support\ServiceProvider;

class TournamentServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->singleton(Tournament::class, function ($app) {
            // Get gender ID from request object
            $genderId = request()->integer('gender_id');

            // Returns the concrete class instance by gender ID
            return match ($genderId) {
                Gender::MALE => $this->app->make(MaleTournament::class),
                Gender::FEMALE => $this->app->make(FemaleTournament::class),
                default => throw new InvalidGenderIdFromRequestException,
            };
        });
    }
}
