<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Game;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserThrows>
 */
class UserThrowsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $dart = array();
        for($i=0; $i<=2; $i++) {
            $dart[] = $this->randomThrow();
        }

        $total = array_sum($dart);

        return [
            'uuid' => $this->faker->unique()->uuid(),
            'dart_1' => $dart[0],
            'dart_2' => $dart[1],
            'dart_3' => $dart[2],
            'total' => $total,
            'game_uuid' => Game::all()->random()->uuid,
        ];
    }

    /**
     * 
     */
    private function randomThrow()
    {
        $missChance = 10;

        return $this->faker->boolean(100-$missChance)
            ? $this->faker->numberBetween(0, 60)
            : null;
    }
}
