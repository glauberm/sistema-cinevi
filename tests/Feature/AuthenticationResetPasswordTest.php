<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class AuthenticationResetPasswordTest extends TestCase
{
    use RefreshDatabase;

    public function testResetPasswordView(): void
    {
        $user = User::factory()
            ->state(['is_enabled' => true])
            ->state(['is_confirmed' => true])
            ->createOne();

        $url = URL::temporarySignedRoute(
            'authentication.reset-password',
            CarbonImmutable::now()->addMinutes(60),
            ['id' => $user->id]
        );

        $this->get($url)
            ->assertOk();
    }

    public function testResetPassword(): void
    {
        $user = User::factory()
            ->state(['is_enabled' => true])
            ->state(['is_confirmed' => true])
            ->createOne();

        $url = URL::temporarySignedRoute(
            'authentication.reset-password--action',
            CarbonImmutable::now()->addMinutes(60),
            ['id' => $user->id]
        );

        $this->post($url, [
            'password' => 'Gl@uberM0ta7!',
            'password_confirmation' => 'Gl@uberM0ta7!',
        ])
            ->assertStatus(302)
            ->assertRedirect('entrada');
    }
}
