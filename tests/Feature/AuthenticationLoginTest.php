<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationLoginTest extends TestCase
{
    use RefreshDatabase;

    public function testLoginView(): void
    {
        $this->get('entrada')
            ->assertOk();
    }

    public function testLogin(): void
    {
        $user = User::factory()
            ->state(['is_enabled' => true])
            ->state(['is_confirmed' => true])
            ->createOne();

        $this->post('entrada', [
            'email' => $user->email,
            'password' => 'Gl@uberM0ta7!',
        ])
            ->assertStatus(302)
            ->assertRedirect('');
    }

    public function testLoginError(): void
    {
        $this->post('entrada', [
            'email' => 'email@errado.com',
            'password' => 'Gl@uberM0ta7!',
        ])
            ->assertStatus(302)
            ->assertRedirect('entrada');
    }
}
