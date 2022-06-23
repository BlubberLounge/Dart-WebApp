<?php

namespace App\Http\Controllers;

use App\Models\Gamemode;
use App\Http\Requests\StoreGamemodeRequest;
use App\Http\Requests\UpdateGamemodeRequest;

class GamemodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreGamemodeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGamemodeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Gamemode  $gamemode
     * @return \Illuminate\Http\Response
     */
    public function show(Gamemode $gamemode)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Gamemode  $gamemode
     * @return \Illuminate\Http\Response
     */
    public function edit(Gamemode $gamemode)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateGamemodeRequest  $request
     * @param  \App\Models\Gamemode  $gamemode
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGamemodeRequest $request, Gamemode $gamemode)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Gamemode  $gamemode
     * @return \Illuminate\Http\Response
     */
    public function destroy(Gamemode $gamemode)
    {
        //
    }
}
