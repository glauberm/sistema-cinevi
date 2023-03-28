<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
 */
class BookingFactory extends Factory
{
    /**
     * @return array<string,mixed>
     */
    public function definition(): array
    {
        $owner = User::factory()->createOne();

        $project = Project::factory()->createOne();

        $year = \sprintf('%02d', $this->faker->numberBetween(2022, 2024));
        $month = \sprintf('%02d', $this->faker->numberBetween(1, 12));
        $day = \sprintf('%02d', $this->faker->numberBetween(1, 28));

        $withdrawalDate = CarbonImmutable::parse("{$year}-{$month}-{$day}");
        $devolutionDate = $withdrawalDate->addDays($this->faker->numberBetween(3, 30));

        return [
            'withdrawal_date' => $withdrawalDate,
            'devolution_date' => $devolutionDate,
            'owner_id' => $owner->id,
            'project_id' => $project->id,
        ];
    }
}
