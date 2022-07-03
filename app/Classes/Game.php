<?php

namespace App\Classes;


/**
 * Dartboard
 */
class Game
{    
    /**
     * @var array
     */
    public $board;
    
    /**
     *
     * @return void
     */
    public function __construct()
    {
        $this->board = new Dartboard();
    }


}