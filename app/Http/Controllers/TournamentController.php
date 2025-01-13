<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTournamentRequest;
use App\Http\Resources\TournamentResource;
use App\Models\Tournament as TournamentModel;
use App\Services\TournamentFacade as Tournament;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * @OA\Info(
 *     title="Tennis Torunament API",
 *     version="1.0.0",
 *     description="API que permite simular un torneo de tenis y consultar los resultados.",
 *     @OA\Contact(
 *         email="egarofalo83@gmail.com"
 *     )
 * )
 */
class TournamentController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/tournaments",
     *     summary="Obtiene todos los torneos",
     *     tags={"Tournaments"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de torneos",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="name", type="string"),
     *                 @OA\Property(property="gender", type="string"),
     *                 @OA\Property(
     *                     property="winner",
     *                     type="object",
     *                     @OA\Property(property="id", type="integer"),
     *                     @OA\Property(property="name", type="string"),
     *                     @OA\Property(property="skill_level", type="integer"),
     *                     @OA\Property(property="gender", type="string"),
     *                     @OA\Property(property="created_at", type="string", example="13-01-2025 16:30:00"),
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
            TournamentResource::collection(
                TournamentModel::with('gender', 'winner.gender')->get()
            )
        );
    }

    /**
     * @OA\Post(
     *     path="/api/tournaments",
     *     summary="Crear un torneo",
     *     description="Crear un nuevo torneo con jugadores. Los campos 'male_skills' o 'female_skills' son requeridos dependiendo del valor de 'gender_id'. Por lo tanto en el torneo masculino para cada jugador se debe especificar 'male_skills' y en el femenino 'female_skills'.",
     *     tags={"Tournaments"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Datos del torneo",
     *         @OA\JsonContent(
     *             type="object",
     *             required={"gender_id", "name", "players"},
     *             @OA\Property(property="gender_id", type="integer", example=2, description="ID del género del torneo (1 para femenino, 2 para masculino)."),
     *             @OA\Property(property="name", type="string", maxLength=100, example="Copa Davis Argentina", description="Nombre del torneo."),
     *             @OA\Property(
     *                 property="players",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     required={"name", "skill_level"},
     *                     @OA\Property(property="name", type="string", maxLength=100, example="Roger Federer", description="Nombre del jugador."),
     *                     @OA\Property(property="skill_level", type="integer", example=99, description="Nivel de habilidad del jugador."),
     *                     @OA\Property(
     *                         property="male_skills",
     *                         type="object",
     *                         description="Se debe especificar cuando se esta creando un torneo masculino",
     *                         @OA\Property(property="strength", type="integer", example=200, description="Fuerza de saque del jugador masculino."),
     *                         @OA\Property(property="speed", type="integer", example=7, description="Velocidad del jugador masculino.")
     *                     ),
     *                     @OA\Property(
     *                         property="female_skills",
     *                         type="object",
     *                         description="Se debe especificar cuando se esta creando un torneo femenino",
     *                         @OA\Property(property="reaction_time", type="integer", example=500, description="Tiempo de reacción del jugador femenino.")
     *                     )
     *                 )
     *             ),
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Torneo creado exitosamente",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=2),
     *             @OA\Property(property="name", type="string", example="Copa Davis Argentina"),
     *             @OA\Property(
     *                 property="winner",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="name", type="string"),
     *                 @OA\Property(property="skill_level", type="integer"),
     *                 @OA\Property(property="gender", type="string"),
     *                 @OA\Property(property="created_at", type="string", example="13-01-2025 16:30:00"),
     *             ),
     *             @OA\Property(property="created_at", type="string", example="13-01-2025 16:30:00"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Errores de validación",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(property="errors", type="object")
     *         )
     *     )
     * )
     */
    public function store(StoreTournamentRequest $request)
    {
        return response()->apiResponse(
            new TournamentResource(
                Tournament::create(
                    $request->validated(),
                    true
                )->load('winner.skills')
            ),
            Response::HTTP_CREATED
        );
    }

    /**
     * @OA\Get(
     *     path="/api/tournaments/{id}",
     *     summary="Obtiene los detalles de un torneo",
     *     tags={"Tournaments"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del torneo",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detalles del torneo",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer"),
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="gender", type="string"),
     *             @OA\Property(
     *                 property="winner",
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
     *                      )
     *                  ),
     *                  @OA\Property(property="created_at", type="string", example="13-01-2025 16:30:00"),
     *             ),
     *             @OA\Property(
     *                 property="players",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer"),
     *                     @OA\Property(property="name", type="string"),
     *                     @OA\Property(property="skill_level", type="integer"),
     *                     @OA\Property(property="gender", type="string"),
     *                     @OA\Property(property="created_at", type="string", example="13-01-2025 16:30:00")
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function show(TournamentModel $tournament)
    {
        return response()->apiResponse(
            new TournamentResource($tournament->load(
                'gender',
                'winner.gender',
                'winner.skills',
                'players.gender'
            ))
        );
    }
}
