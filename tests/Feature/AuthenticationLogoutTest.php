<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationLogoutTest extends TestCase
{
    use RefreshDatabase;

    public function testLogout(): void
    {
        $user = User::factory()
            ->state(['is_enabled' => true])
            ->state(['is_confirmed' => true])
            ->createOne();

        $this->actingAs($user)
            ->post('saida')
            ->assertRedirect('entrada');
    }
}
