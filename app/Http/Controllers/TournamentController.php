<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTournamentRequest;
use App\Models\Tournament as TournamentModel;
use App\Services\TournamentFacade as Tournament;

class TournamentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return TournamentModel::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTournamentRequest $request)
    {
        return Tournament::create($request->validated(), true);
    }

    /**
     * Display the specified resource.
     */
    public function show(TournamentModel $tournament)
    {
        return $tournament;
    }
}
