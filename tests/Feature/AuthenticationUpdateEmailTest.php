<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class AuthenticationUpdateEmailTest extends TestCase
{
    use RefreshDatabase;

    public function testUpdateEmail()
    {
        $user = User::factory()
            ->state(['is_enabled' => true])
            ->state(['is_confirmed' => true])
            ->createOne();

        $url = URL::temporarySignedRoute(
            'authentication.update_email',
            CarbonImmutable::now()->addMinutes(60),
            ['email' => $user->email]
        );

        $this->actingAs($user)
            ->get($url)
            ->assertStatus(302)
            ->assertRedirect('entrada');
    }
}
