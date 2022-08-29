<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Bookable>
 */
class BookableFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'identifier' => $this->faker->numerify('##-##'),
            'name' => $this->faker->word(),
            'inventory_number' => $this->faker->randomNumber(5, true),
            'serial_number' => $this->faker->randomNumber(5, true),
            'accessories' => $this->faker->text(),
            'notes' => $this->faker->text(),
            'is_under_maintenance' => $this->faker->boolean(),
            'is_return_overdue' => $this->faker->boolean(),
        ];
    }
}
