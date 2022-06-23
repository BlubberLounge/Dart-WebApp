<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dartboard extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Get owner of this Dartboard
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'owned_by');
    }
    
    /**
     * Get current game
     */
    public function game() 
    {
        return $this->hasMany(Game::class);
    }
}
