<?php

namespace App\Http\Controllers;

use App\Http\Resources\PlayerResource;
use App\Models\Player;
use Illuminate\Http\JsonResponse;

class PlayerController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/players",
     *     summary="Obtiene todos los jugadores",
     *     tags={"Players"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de jugadores",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="name", type="string"),
     *                 @OA\Property(property="skill_level", type="integer"),
     *                 @OA\Property(property="gender", type="string"),
     *                 @OA\Property(
     *                     property="skills",
     *                     type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(property="name", type="string"),
     *                         @OA\Property(property="score", type="string"),
     *                     )
     *                 ),
     *                 @OA\Property(property="created_at", type="string", example="13-01-2025 16:30:00")
     *             )
     *         )
     *     )
     * )
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
     * @OA\Get(
     *     path="/api/players/{id}",
     *     summary="Obtiene los detalles de un jugador",
     *     tags={"Players"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del jugador",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detalles de un jugador",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="name", type="string"),
     *                 @OA\Property(property="skill_level", type="integer"),
     *                 @OA\Property(property="gender", type="string"),
     *                 @OA\Property(
     *                     property="skills",
     *                     type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(property="name", type="string"),
     *                         @OA\Property(property="score", type="string"),
     *                     )
     *                 ),
     *                 @OA\Property(
     *                     property="tournaments",
     *                     type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(property="id", type="integer"),
     *                         @OA\Property(property="name", type="string"),
     *                         @OA\Property(property="created_at", type="string", example="13-01-2025 16:30:00"),
     *                     )
     *                 ),
     *                 @OA\Property(property="created_at", type="string", example="13-01-2025 16:30:00"),
     *             )
     *         )
     *     )
     * )
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
