<?php

namespace Database\Factories;

use App\Models\ProductionCategory;
use App\Models\User;
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
        $owner = User::factory()->createOne();

        $productionCategory = ProductionCategory::factory()->createOne();

        $professor = User::factory()->createOne();

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
            'has_attended_photography_discipline' => $this->faker->boolean(),
            'has_attended_sound_discipline' => $this->faker->boolean(),
            'has_attended_art_discipline' => $this->faker->boolean(),
            'owner_id' => $owner->id,
            'production_category_id' => $productionCategory->id,
            'professor_id' => $professor->id,
        ];
    }
}
