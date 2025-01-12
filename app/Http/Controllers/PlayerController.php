<?php

namespace App\Http\Controllers;

use App\Http\Resources\PlayerResource;
use App\Models\Player;
use Illuminate\Http\JsonResponse;

class PlayerController extends Controller
{
    /**
     * Display a listing of players.
     * 
     * @return JsonResponse
     */
    public function index()
    {
        return response()->apiResponse(
            PlayerResource::collection(
                Player::with('gender', 'skills')->get()
            )
        );
    }

    /**
     * Display the specified player model.
     * 
     * @param Player $player
     * @return JsonResponse
     */
    public function show(Player $player)
    {
        return response()->apiResponse(
            new PlayerResource(
                $player->load('gender', 'skills', 'tournaments')
            )
        );
    }
}
