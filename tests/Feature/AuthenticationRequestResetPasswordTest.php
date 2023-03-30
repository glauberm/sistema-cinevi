<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Mail\AuthenticationResetPasswordMail;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class AuthenticationRequestResetPasswordTest extends TestCase
{
    use RefreshDatabase;

    public function testRequestResetPasswordView(): void
    {
        $this->get('solicitar-redefinir-senha')
            ->assertOk();
    }

    public function testRequestResetPassword(): void
    {
        Mail::fake();

        $user = User::factory()
            ->state(['is_enabled' => true])
            ->state(['is_confirmed' => true])
            ->createOne();

        $this->post('solicitar-redefinir-senha', ['email' => $user->email])
            ->assertStatus(302)
            ->assertRedirect('entrada');

        Mail::assertQueued(AuthenticationResetPasswordMail::class);
    }
}
