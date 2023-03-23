<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

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
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => 'Gl@uberM0ta7!',
            'phone' => $this->faker->randomNumber(5, true) . $this->faker->randomNumber(6, true),
            'identifier' => $this->faker->randomNumber(7, true),
            'is_enabled' => $this->faker->boolean(),
            'is_confirmed' => $this->faker->boolean(),
            'roles' => [],
        ];
    }
}
