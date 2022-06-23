<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator;
use Illuminate\Container\Container;
use Illuminate\Support\Facades\Schema;

use Database\Factories\GameFactory;
use App\Models\Gamemode;

class GamemodeSeeder extends Seeder
{
        /**
     * The current Faker instance.
     *
     * @var \Faker\Generator
     */
    protected $faker;

    /**
     * Create a new seeder instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->faker = $this->withFaker();
    }

    /**
     * Get a new Faker instance.
     *
     * @return \Faker\Generator
     */
    protected function withFaker()
    {
        return Container::getInstance()->make(Generator::class);
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        // delete all gamemode table columns and reset the increment counter
        Gamemode::truncate();
        Schema::enableForeignKeyConstraints();

        $iconList = ['gamepad', 'chess', 'chess-bishop', 'dice', 'hand', 'hand-lizard', 'fire-flame-curved',
                     'hand-scissors', 'puzzle-piece', 'volleyball', 'ring', 'dragon', 'hat-wizard'];

        Gamemode::create([
            'name' => '301',
            'description' => 'Starting from 301 who ever has a score from 0 first wins',
            'icon' => $this->faker->randomElement($iconList),
            'active' => $this->faker->boolean(65),
        ]);

        Gamemode::create([
            'name' => '401',
            'description' => 'Starting from 401 who ever has a score from 0 first wins',
            'icon' => $this->faker->randomElement($iconList),
            'active' => $this->faker->boolean(65),
        ]);

        Gamemode::create([
            'name' => '501',
            'description' => 'Starting from 501 who ever has a score from 0 first wins',
            'icon' => $this->faker->randomElement($iconList),
            'active' => $this->faker->boolean(65),
        ]);

        Gamemode::create([
            'name' => '601',
            'description' => 'Starting from 601 who ever has a score from 0 first wins',
            'icon' => $this->faker->randomElement($iconList),
            'active' => $this->faker->boolean(65),
        ]);
    }
}
