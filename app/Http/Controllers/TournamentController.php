<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTournamentRequest;
use App\Http\Resources\TournamentResource;
use App\Models\Tournament as TournamentModel;
use App\Services\TournamentFacade as Tournament;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class TournamentController extends Controller
{
    /**
     * Display a listing of all tournaments.
     * 
     * @return JsonResponse
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
     * Store a newly created tournament model in storage.
     * 
     * @param $request StoreTournamentRequest
     * @return JsonResponse
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
     * Display the specified tournament model.
     * 
     * @param TournamentModel $tournament
     * @return JsonResponse
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
