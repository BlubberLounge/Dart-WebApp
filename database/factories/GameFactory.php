<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\User;
use App\Models\Gamemode;
use App\Models\Dartboard;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Game>
 */
class GameFactory extends Factory
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
            'description' => $this->faker->sentence($this->faker->numberBetween(5, 20)),
            'current_leg' => $this->randomLeg(),
            'total_legs' => $this->randomLeg(),
            'state' => $this->randomState(),
            'gamemode_id' => Gamemode::all()->random()->id,
            'dartboard_id' => Dartboard::all()->random()->id,
            // 'created_by' => User::all()->random()->id,
            'modified_by' => User::all()->random()->id,
        ];
    }

    /**
     * Generate a random dartboard name
     * 
     * @return string
     */
    private function randomName()
    {
        $shuffledName = $this->faker->shuffle($this->faker->word());
        $prefix = $this->faker->randomElement(['Game', 'Teamspiel', 'Lappen', 'Pros', 'Arrows', $shuffledName, $shuffledName]);
        $con = $this->faker->randomElement(['#', '-', '.', ' ', '/', '']);
        $suffix = $this->faker->numberBetween(0, 9999);

        return $this->faker->boolean(55)
            ? $prefix.$con.$suffix
            : $prefix.' by '. $this->faker->name();
    }

    /**
     * 
     */
    private function randomLeg()
    {
        return $this->faker->boolean(70)
            ? $this->faker->numberBetween(0, 5)
            : null;
    }

    /**
     * Generate weighted game states
     * 
     * use "SELECT state AS state, count(*) * 100.0 / sum(count(*)) Over() as 'Percentage' FROM dwa_games GROUP BY state;"
     * to check if it worked
     */
    private function randomState()
    {
        $stateList = ['STARTED', 'RUNNING', 'CONTINUED', 'PAUSED', 'FINISHED', 'STOPPED', 'CLOSED'];
        
        /* STARTED      30%
         * RUNNING      25%
         * CONTINUED     5%
         * PAUSED        5%
         * FINISHED     25%
         * STOPPED      10%
         * CLOSED       100%-missing%
         */
        $weights = [15, 28, 5, 5, 35, 10];
        $weights[] = 100-array_sum($weights);

        return $this->weighted_random_simple($stateList, $weights);
    }

    /**
     * weighted_random_simple()
     * Pick a random item based on weights.
     *
     * @param array $values Array of elements to choose from 
     * @param array $weights An array of weights. Weight must be a positive number.
     * @return mixed Selected element.
     */
    private function weighted_random_simple($values, $weights){ 
        $count = count($values); 
        $i = 0; 
        $n = 0; 
        $num = mt_rand(1, array_sum($weights)); 
        while($i < $count){
            $n += $weights[$i]; 
            if($n >= $num){
                break; 
            }
            $i++; 
        } 
        return $values[$i]; 
    }
}
