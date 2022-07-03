<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use App\Http\Requests\StoreGameRequest;
use App\Http\Requests\UpdateGameRequest;
use App\Models\Dartboard;
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
        $u = new User();
        $d = new Dartboard();

        $data = array();
        $data['user'] = Auth::user();
        $data['players'] = $u->getAllPlayers();
        $data['dartboards'] = $d->getAllActive();

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
        $g = new Game();
        $g->uuid = Str::uuid()->toString();

    
        $g->save();

        foreach($request->players as $p)
        {
            // TODO check if player is available
            $u = User::find($p)->get();
            $u->game_id = $g->id;
        }

        return redirect()->route('game.show', $g->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function show(Game $game)
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
