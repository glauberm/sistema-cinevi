<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Configuration>
 */
class ConfigurationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'id' => 1,
            'bookings_are_closed' => false,
            'bookings_forbidden_dates' => [
                [
                    'month' => '01',
                    'day' => '01',
                    'name' => $this->faker->word(),
                ],
            ],
            'final_copies_confirmation_message' => $this->faker->text(),
        ];
    }
}
