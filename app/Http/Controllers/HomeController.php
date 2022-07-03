<?php

namespace App\Http\Controllers;

use App\Classes\Dartboard;
use App\Classes\Wedge;
use Illuminate\Http\Request;

use App\Models\User;

/**
 * HomeController
 */
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $d = new Dartboard();

        dd($d->getWedgeValue(10, 361.11, true));
        return view('home');
    }
}
