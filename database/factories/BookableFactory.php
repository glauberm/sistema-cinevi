<?php

namespace Database\Factories;

use App\Models\BookableCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Bookable>
 */
class BookableFactory extends Factory
{
    /**
     * @return array<string,mixed>
     */
    public function definition(): array
    {
        $bookableCategory = BookableCategory::factory()->createOne();

        return [
            'identifier' => $this->faker->numerify('##-##'),
            'name' => $this->faker->word(),
            'inventory_number' => $this->faker->randomNumber(5, true),
            'serial_number' => $this->faker->randomNumber(5, true),
            'accessories' => $this->faker->text(),
            'notes' => $this->faker->text(),
            'is_under_maintenance' => $this->faker->boolean(),
            'is_return_overdue' => $this->faker->boolean(),
            'bookable_category_id' => $bookableCategory->id,
        ];
    }
}
