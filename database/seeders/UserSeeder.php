<?php

namespace Database\Seeders;

use App\Models\Dartboard;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Sequence;

use App\Models\User;
use App\Models\Role;
use App\Models\Game;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // user that own a Dartboard
        User::factory()
            ->count(rand(8, 13))
            ->hasDartboard(1)
            ->create();

        // user that have created a game
        User::factory()
            ->count(rand(9, 21))
            ->hasGameCreated(rand(2,11))
            ->create();

        // in-game User
        User::factory()
            ->count(rand(21, 33))
            ->hasGame(rand(2, 11))
            ->hasThrows(rand(36, 78))
            ->create();
                
        // always create one initial admin / root user
        User::create([
            'name' => 'Admin',
            'firstname' => 'Blubber',
            'lastname' => 'Lounge',
            'email' => 'admin@blubber-lounge.de',
            'email_verified_at' => now(),
            'role_id' => Role::ADMIN,
            'game_id' => null,
            'password' => Hash::make('123'),
        ]);
    }
}
