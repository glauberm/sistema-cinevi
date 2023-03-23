<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationUpdatePasswordTest extends TestCase
{
    use RefreshDatabase;

    public function testUpdatePasswordView()
    {
        $user = User::factory()
            ->state(['is_enabled' => true])
            ->state(['is_confirmed' => true])
            ->createOne();

        $this->actingAs($user)
            ->get('atualizar-senha')
            ->assertOk();
    }

    public function testUpdatePassword()
    {
        $user = User::factory()
            ->state(['is_enabled' => true])
            ->state(['is_confirmed' => true])
            ->createOne();

        $this->actingAs($user)
            ->post('atualizar-senha', [
                'password' => 'Gl@uberM0ta7!',
                'new_password' => 'M0taGl@uber7!',
                'new_password_confirmation' => 'M0taGl@uber7!',
            ])
            ->assertStatus(302)
            ->assertRedirect('entrada');
    }
}
