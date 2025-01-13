<?php

use App\Providers\TournamentServiceProvider;
use L5Swagger\L5SwaggerServiceProvider;

return [
    App\Providers\AppServiceProvider::class,
    TournamentServiceProvider::class,
    L5SwaggerServiceProvider::class,
];
