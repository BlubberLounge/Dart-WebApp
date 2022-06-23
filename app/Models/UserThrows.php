<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserThrows extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * 
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 
     */
    public function game()
    {
        return $this->belongsTo(Game::class, 'uuid', 'game_uuid');
    }
}
