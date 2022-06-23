<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'uuid',
        'name',
        'description',
        'current_leg',
        'total_legs',
        'state',
        'gamemode_id',
        'created_by',
        'modified_by'
    ];

    /**
     * Get all users for this Game
     */
    public function users() 
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get the game creator
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    /**
     * Get the last user that modified this game
     */
    public function modifiedBy()
    {
        return $this->belongsTo(User::class, 'modified_by');
    }

    /**
     * Get gamemode
     */
    public function gamemode()
    {
        return $this->belongsTo(Gamemode::class);
    }

    public function dartboard()
    {
        $this->belongsTo(Dartboard::class);
    }

    /**
     * Get throws
     */
    public function throws()
    {
        return $this->hasMany(UserThrows::class, 'game_uuid', 'uuid');
    }
}
