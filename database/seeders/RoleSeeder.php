<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
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
            'id' => Role::ADMIN,
            'name' => 'Admin',
            'description' => 'Has the most permissions. should be the highest role.',
        ]);
        
        Role::create([
            'id' => Role::MANAGEMENT,
            'name' => 'Management',
            'description' => 'Placeholder role.',
        ]);
        
        Role::create([
            'id' => Role::GAME_MASTER,
            'name' => 'Game Master',
            'description' => 'Basically a player but in addition this role can control a game.',
        ]);

        Role::create([
            'id' => Role::PLAYER,
            'name' => 'Player',
            'description' => 'Just a dart player.',
        ]);
    }
}
