<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /*
     * Define role IDs here 
     */
    const ADMIN = 1;
    const MANAGEMENT = 2;
    const GAME_MASTER = 3;
    const PLAYER = 4;


    /**
     * Get users with this role.
     */
    public function user() 
    {
        return $this->hasMany(User::class);
    }
}
