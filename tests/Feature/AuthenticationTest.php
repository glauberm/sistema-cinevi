<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Mail\AuthenticationFinalizeRegistrationMail;
use App\Mail\AuthenticationResetPasswordMail;
use App\Mail\AuthenticationUpdateEmailMail;
use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function testLogin(): void
    {
        $user = User::factory()
            ->state(['is_enabled' => true])
            ->state(['is_confirmed' => true])
            ->createOne();

        $response = $this->post('api/entrada', [
            'email' => $user->email,
            'password' => 'Gl@uber7!',
        ]);

        $response->assertOk();
    }

    public function testLoginErrorWithWrongPassword(): void
    {
        $user = User::factory()->createOne();

        $response = $this->post('api/entrada', [
            'email' => $user->email,
            'password' => '7Gl@uber!',
        ]);

        $response->assertStatus(401);
    }

    public function testLogout(): void
    {
        Sanctum::actingAs(User::factory()->createOne());

        $response = $this->post('api/saida');

        $response->assertOk();
    }

    public function testGetAuthenticatedUser(): void
    {
        Sanctum::actingAs(User::factory()->createOne());

        $response = $this->json('GET', 'api/usuario-autenticado');

        $response->assertOk();
    }

    public function testRegister(): void
    {
        Mail::fake();

        $email = 'glauber@cinemauff.com.br';

        $response = $this->post('api/cadastro', [
            'name' => 'Glauber Mota',
            'email' => $email,
            'email_confirmation' => $email,
            'password' => 'Gl@uber7!',
            'phone' => '21997963685',
            'identifier' => '1345024',
        ]);

        $response->assertOk();

        Mail::assertQueued(
            AuthenticationFinalizeRegistrationMail::class,
            function (AuthenticationFinalizeRegistrationMail $mail) use ($email) {
                return $mail->hasTo($email);
            }
        );

        Mail::assertQueued(AuthenticationFinalizeRegistrationMail::class, 1);
    }

    public function testFinalizeRegistration(): void
    {
        $user = User::factory()->state(['is_enabled' => false])->createOne();

        $url = URL::temporarySignedRoute(
            'authentication.finalize_registration',
            CarbonImmutable::now()->addMinutes(60),
            ['id' => $user->id]
        );

        Sanctum::actingAs($user);

        $response = $this->put($url);

        $response->assertOk();

        $this->assertDatabaseHas('users', ['id' => $user->id, 'is_enabled' => true]);
    }

    public function testRequestResetPassword(): void
    {
        Mail::fake();

        $user = User::factory()->createOne();

        $response = $this->post('api/solicitar-redefinir-senha', ['email' => $user->email]);

        $response->assertOk();

        Mail::assertQueued(AuthenticationResetPasswordMail::class, function ($mail) use ($user) {
            return $mail->hasTo($user->email);
        });

        Mail::assertQueued(AuthenticationResetPasswordMail::class, 1);
    }

    public function testRequestResetPasswordErrorWithWrongEmail(): void
    {
        $response = $this->post('api/solicitar-redefinir-senha', [
            'email' => 'email.errado@gmail.com',
        ]);

        $response->assertStatus(404);
    }

    public function testResetPassword(): void
    {
        $user = User::factory()->createOne();

        $url = URL::temporarySignedRoute(
            'authentication.reset_password',
            CarbonImmutable::now()->addMinutes(60),
            ['id' => $user->id]
        );

        $response = $this->put($url, [
            'password' => 'Gl@uber7!',
            'password_confirmation' => 'Gl@uber7!',
        ]);

        $response->assertOk();
    }

    public function testRequestUpdateEmail(): void
    {
        Mail::fake();

        $user = User::factory()->createOne();

        Sanctum::actingAs($user);

        $response = $this->post('api/solicitar-atualizar-email', [
            'email' => $user->email,
            'email_confirmation' => $user->email,
            'password' => 'Gl@uber7!',
        ]);

        $response->assertOk();

        Mail::assertQueued(AuthenticationUpdateEmailMail::class, function ($mail) use ($user) {
            return $mail->hasTo($user->email);
        });

        Mail::assertQueued(AuthenticationUpdateEmailMail::class, 1);
    }

    public function testUpdateEmail(): void
    {
        $user = User::factory()->createOne();

        $url = URL::temporarySignedRoute(
            'authentication.update_email',
            CarbonImmutable::now()->addMinutes(60),
            ['id' => $user->id, 'email' => $user->email]
        );

        Sanctum::actingAs($user);

        $response = $this->put($url);

        $response->assertOk();

        $this->assertDatabaseHas('users', ['id' => $user->id, 'email' => $user->email]);
    }

    public function testUpdatePassword(): void
    {
        $user = User::factory()->createOne();

        Sanctum::actingAs($user);

        $response = $this->put('api/atualizar-senha', [
            'password' => 'Gl@uber7!',
            'new_password' => '7Gl@uber!',
            'new_password_confirmation' => '7Gl@uber!',
        ]);

        $response->assertOk();
    }
}
