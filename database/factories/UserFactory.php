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
            'password' => 'Gl@uber7!',
            'phone' => $this->faker->phoneNumber(),
            'identifier' => $this->faker->randomNumber(),
            'is_confirmed' => $this->faker->boolean(),
            'is_professor' => $this->faker->boolean(),
            'roles' => \json_encode(['user']),
        ];
    }
}
