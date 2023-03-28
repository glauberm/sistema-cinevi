<?php

namespace Database\Factories;

use App\Models\ProductionCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FinalCopy>
 */
class FinalCopyFactory extends Factory
{
    /**
     * @return array<string,mixed>
     */
    public function definition(): array
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
            'video_url' => $this->faker->url(),
            'video_password' => $this->faker->word(),
            'chromia' => $this->faker->word(),
            'proportion' => $this->faker->word(),
            'format' => $this->faker->word(),
            'duration' => $this->faker->word(),
            'native_digital_format' => $this->faker->word(),
            'codec' => $this->faker->word(),
            'container' => $this->faker->word(),
            'bitrate' => $this->faker->word(),
            'fps' => $this->faker->word(),
            'sound' => $this->faker->word(),
            'digital_sound_resolution' => $this->faker->word(),
            'digital_matrix_support' => $this->faker->word(),
            'camera' => $this->faker->word(),
            'editing_software' => $this->faker->word(),
            'sound_capture_equipment' => $this->faker->word(),
            'budget' => $this->faker->randomNumber(5, true),
            'financing_sources' => $this->faker->text(),
            'supporters' => $this->faker->text(),
            'has_dcp' => $this->faker->boolean(),
            'cast' => $this->faker->text(),
            'participations' => $this->faker->text(),
            'prizes' => $this->faker->text(),
            'confirmed' => $this->faker->boolean(),
            'owner_id' => $owner->id,
            'production_category_id' => $productionCategory->id,
            'professor_id' => $professor->id,
        ];
    }
}
