<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\Configuration;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ConfigurationCrudTest extends TestCase
{
    use RefreshDatabase;

    public function testUpdateView(): void
    {
        $user = User::factory()
            ->state(['is_enabled' => true])
            ->state(['is_confirmed' => true])
            ->state(['roles' => [UserRole::Admin]])
            ->createOne();

        Configuration::factory()
            ->createOne();

        $this->actingAs($user)
            ->get('configuracoes')
            ->assertOk();
    }

    public function testUpdate(): void
    {
        $user = User::factory()
            ->state(['is_enabled' => true])
            ->state(['is_confirmed' => true])
            ->state(['roles' => [UserRole::Admin]])
            ->createOne();

        Configuration::factory()
            ->createOne();

        $this->actingAs($user)
            ->post('configuracoes', [
                'bookings_are_closed' => true,
                'bookings_forbidden_dates' => [
                    [
                        'month' => '02',
                        'day' => '16',
                        'name' => 'Lorem Ipsum',
                    ]
                ],
                'final_copies_confirmation_message' => 'Lorem Ipsum Dolor Sit Amet',
            ])
            ->assertStatus(302)
            ->assertRedirect('configuracoes');

        $this->assertDatabaseHas('configurations', [
            'bookings_are_closed' => 1,
            'bookings_forbidden_dates' => "[{\"month\":\"02\",\"day\":\"16\",\"name\":\"Lorem Ipsum\"}]",
            'final_copies_confirmation_message' => 'Lorem Ipsum Dolor Sit Amet',
        ]);

        $this->assertDatabaseCount('configurations_versions', 1);
    }
}
