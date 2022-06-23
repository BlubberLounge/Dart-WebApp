<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

use App\Models\Role;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $this->faker->locale('de_DE');

        return [
            'name' => $this->faker->unique()->userName(),
            'firstname' => $this->faker->firstName(),
            'lastname' => $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => Hash::make('password'),
            'role_id' => $this->randomRole(),
        ];
    }

    /**
     * 
     */
    private function randomRole()
    {
        $roleList = [Role::MANAGEMENT, Role::GAME_MASTER, Role::PLAYER];
        
        /* ADMIN        0% (only 1 Admin accout per application)
         * MANAGEMENT   2%
         * GAME_MASTER  40%
         * PLAYER       100%-missing%
         */
        $weights = [5, 45];
        $weights[] = 100-array_sum($weights);

        return $this->weighted_random_simple($roleList, $weights);
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
