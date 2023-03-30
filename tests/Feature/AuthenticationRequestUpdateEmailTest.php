<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Mail\AuthenticationUpdateEmailMail;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class AuthenticationRequestUpdateEmailTest extends TestCase
{
    use RefreshDatabase;

    public function testRequestUpdateEmailView(): void
    {
        $user = User::factory()
            ->state(['is_enabled' => true])
            ->state(['is_confirmed' => true])
            ->createOne();

        $this->actingAs($user)
            ->get('solicitar-atualizar-email')
            ->assertOk();
    }

    public function testRequestUpdateEmail(): void
    {
        Mail::fake();

        $user = User::factory()
            ->state(['is_enabled' => true])
            ->state(['is_confirmed' => true])
            ->createOne();

        $this->actingAs($user)
            ->post('solicitar-atualizar-email', [
                'email' => $user->email,
                'email_confirmation' => $user->email,
                'password' => 'Gl@uberM0ta7!',
            ])
            ->assertStatus(302)
            ->assertRedirect('entrada');

        Mail::assertQueued(AuthenticationUpdateEmailMail::class);
    }
}
