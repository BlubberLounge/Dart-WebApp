<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Casts\Attribute;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'firstname',
        'lastname',
        'email',
        'password',
        'role_id',
        'game_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * UserModel, RoleModel Relation. Get the users role.
     */
    public function role() 
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Get the current game
     */
    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    /**
     * 
     */
    public function gameCreated()
    {
        return $this->hasMany(Game::class, 'created_by');
    }

    /**
     * 
     */
    public function dartboard()
    {
        return $this->hasMany(Dartboard::class, 'owned_by');
    }

    /**
     * 
     */
    public function throws()
    {
        return $this->hasMany(UserThrows::class);
    }

    /**
     * Get name of users role
     */
    public function getRoleName()
    {
        return $this->role !== null 
            ? $this->role->name
            : '-'; 
    }

    /**
     * Firstname + lastname
     * 
     * @return string
     */
    public function getFullname()
    {
        return $this->firstname .' '. $this->lastname;
    }

    /**
     * Get all Users with ROLE = PLAYER
     * 
     * @return array
     */
    public function getAllPlayers()
    {
        return $this->where('role_id', Role::PLAYER)->orderBy('id','asc')->get();
    }

    /**
     * Get all Users with ROLE = GAME MASTER
     */
    public function getAllGameMasters()
    {
        return $this->where('role_id', Role::GAME_MASTER)->orderBy('id','asc')->get();
    }
}
