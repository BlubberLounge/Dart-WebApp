<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\User;
use App\Models\Game;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Dartboard>
 */
class DartboardFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'uuid' => $this->faker->unique()->uuid(),
            'name' => $this->randomName(),
            'description' => $this->faker->sentence($this->faker->numberBetween(10, 25)),
            'image_path' => '/img/dartboards/bl_placeholder.png',
            'active' => $this->faker->boolean(65),
            // 'owned_by' => User::all()->random()->id,
        ];
    }

    /**
     * Generate a random dartboard name
     * 
     * @return string
     */
    private function randomName()
    {
        $prefix = $this->faker->randomElement(['Dartboard', 'BL Board', 'Board', 'Brett', 'Dartini']);
        $con = $this->faker->randomElement(['#', '-', '.', ' ', '/', '']);
        $suffix = $this->faker->numberBetween(0, 25);

        return $this->faker->boolean(55)
            ? $prefix.$con.$suffix
            : $prefix.' by '. User::all()->random()->firstname;
    }
}
