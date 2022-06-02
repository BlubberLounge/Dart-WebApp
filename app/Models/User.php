<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;

class User extends Model implements Authenticatable
{
    use HasFactory, \Illuminate\Auth\Authenticatable;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * UserModel, RoleModel Relation. Get the users role.
     */
    public function role() 
    {
        return $this->belongsTo(Role::class);
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
}
