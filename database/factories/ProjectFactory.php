<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $this->faker->word(),
            'synopsis' => $this->faker->text(),
            'genres' => $this->faker->words(),
            'capture_format' => $this->faker->word(),
            'capture_notes' => $this->faker->text(),
            'venues' => $this->faker->text(),
            'pre_production_date' => $this->faker->date(),
            'production_date' => $this->faker->date(),
            'post_production_date' => $this->faker->date(),
            'has_attended_photography_discipline' => $this->faker->bool(),
            'has_attended_sound_discipline' => $this->faker->bool(),
            'has_attended_art_discipline' => $this->faker->bool(),
        ];
    }
}
