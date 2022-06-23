<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests\StoreGameRequest;

use App\Models\Game;
use App\Models\User;


/**
 * GameController
 */
class GameController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->authorizeResource(User::class, 'user');
    }

    /**
     * Show the application dashboard.
     *
     */
    public function index()
    {
        $data = array();

        return view('game.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $u = new User;

        $data = array();
        $data['user'] = Auth::user();
        $data['players'] = $u->getAllPlayers();

        return view('game.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreGameRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGameRequest $request)
    {
        $u = new Game();

        $u->save();

        return redirect()->route('game.index', $u->id)
            ->with('success','User has been created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Game  $user
     * @return \Illuminate\Http\Response
     */
    public function show(Game $user)
    {
        dd('test');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function edit(Game $game)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateGameRequest  $request
     * @param  \App\Models\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGameRequest $request, Game $game)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function destroy(Game $game)
    {

    }
}
