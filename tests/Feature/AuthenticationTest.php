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

    /**
     * Testa o login.
     *
     * @return void
     */
    public function testLogin()
    {
        $user = User::factory()->createOne();

        $response = $this->post('api/entrada', [
            'email' => $user->email,
            'password' => 'Gl@uber7!',
        ]);

        $response->assertOk();
    }

    /**
     * Testa o login com uma senha errada, esperando um erro.
     *
     * @return void
     */
    public function testLoginErrorWithWrongPassword()
    {
        $user = User::factory()->createOne();

        $response = $this->post('api/entrada', [
            'email' => $user->email,
            'password' => '7Gl@uber!',
        ]);

        $response->assertStatus(401);
    }

    /**
     * Testa o login.
     *
     * @return void
     */
    public function testLogout()
    {
        Sanctum::actingAs(User::factory()->createOne());

        $response = $this->post('api/saida');

        $response->assertOk();
    }

    /**
     * Testa a exibição do usuário autenticado.
     *
     * @return void
     */
    public function testGetAuthenticatedUser()
    {
        Sanctum::actingAs(User::factory()->createOne());

        $response = $this->json('GET', 'api/usuario-autenticado');

        $response->assertOk();
    }

    /**
     * Testa o envio da requisição de cadastro.
     *
     * @return void
     */
    public function testRegister()
    {
        Mail::fake();

        $email = 'glauber@cinemauff.com.br';

        $response = $this->post('api/cadastro', [
            'name' => 'Glauber Mota',
            'email' => $email,
            'password' => 'Gl@uber7!',
            'phone' => '(21) 99796-3685',
            'identifier' => '1345024',
        ]);

        Mail::assertQueued(
            AuthenticationFinalizeRegistrationMail::class,
            function (AuthenticationFinalizeRegistrationMail $mail) use ($email) {
                return $mail->hasTo($email);
            }
        );

        Mail::assertQueued(AuthenticationFinalizeRegistrationMail::class, 1);

        $response->assertOk();
    }

    /**
     * Testa a redefinição de senha.
     *
     * @return void
     */
    public function testFinalizeRegistration()
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

    /**
     * Testa o envio da requisição de redefinição de senha.
     *
     * @return void
     */
    public function testRequestResetPassword()
    {
        Mail::fake();

        $user = User::factory()->createOne();

        $response = $this->post('api/solicitar-redefinir-senha', ['email' => $user->email]);

        Mail::assertQueued(AuthenticationResetPasswordMail::class, function ($mail) use ($user) {
            return $mail->hasTo($user->email);
        });

        Mail::assertQueued(AuthenticationResetPasswordMail::class, 1);

        $response->assertOk();
    }

    /**
     * Testa o envio da requisição de redefinição de senha com o e-mail errado.
     *
     * @return void
     */
    public function testRequestResetPasswordErrorWithWrongEmail()
    {
        $response = $this->post('api/solicitar-redefinir-senha', [
            'email' => 'email.errado@gmail.com',
        ]);

        $response->assertStatus(404);
    }

    /**
     * Testa a redefinição de senha.
     *
     * @return void
     */
    public function testResetPassword()
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

    /**
     * Testa o envio da requisição de atualização de e-mail.
     *
     * @return void
     */
    public function testRequestUpdateEmail()
    {
        Mail::fake();

        $user = User::factory()->createOne();

        Sanctum::actingAs($user);

        $response = $this->post('api/solicitar-atualizar-email', [
            'email' => $user->email,
            'email_confirmation' => $user->email,
            'password' => 'Gl@uber7!',
        ]);

        Mail::assertQueued(AuthenticationUpdateEmailMail::class, function ($mail) use ($user) {
            return $mail->hasTo($user->email);
        });

        Mail::assertQueued(AuthenticationUpdateEmailMail::class, 1);

        $response->assertOk();
    }

    /**
     * Testa a atualização de email.
     *
     * @return void
     */
    public function testUpdateEmail()
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

    /**
     * Testa a atualização de senha.
     *
     * @return void
     */
    public function testUpdatePassword()
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
