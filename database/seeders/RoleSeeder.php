<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

use App\Models\Role;
use App\Models\User;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        Schema::disableForeignKeyConstraints();
        // delete all role table columns and reset the increment counter
        Role::truncate();
        Schema::enableForeignKeyConstraints();

        /* 
         * User Roles / Permissions
         * Permissions are defined with Laravel Policies system
         */
        Role::create([
            'name' => 'Admin',
            'description' => 'Has the most permissions. should be the highest role.',
        ]);
        
        Role::create([
            'name' => 'Management',
            'description' => 'Placeholder role.',
        ]);
        
        Role::create([
            'name' => 'Game Master',
            'description' => 'Basically a player but in addition this role can control a game.',
        ]);

        Role::create([
            'name' => 'Player',
            'description' => 'Just a dart player.',
        ]);

        
        // always create one initial admin / root user
        User::create([
            'name' => 'Admin',
            'firstname' => 'Blubber',
            'lastname' => 'Lounge',
            'email' => 'admin@blubber-lounge.de',
            'role_id' => 1,
            'password' => Hash::make('123'),
        ]);
    }
}
