<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
 */
class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $owner = User::factory()->createOne();

        $project = Project::factory()->createOne();

        return [
            'withdrawal_date' => $this->faker->date(),
            'devolution_date' => $this->faker->date(),
            'owner_id' => $owner->id,
            'project_id' => $project->id,
        ];
    }
}
