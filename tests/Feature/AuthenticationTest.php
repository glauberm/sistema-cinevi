<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Mail\AuthenticationResetPasswordMail;
use App\Models\User;
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

        $url = URL::temporarySignedRoute('authentication.reset_password', now()->addMinutes(30), ['id' => $user->id]);

        $response = $this->post($url, [
            'password' => 'Gl@uber7!',
            'password_confirmation' => 'Gl@uber7!',
        ]);

        $response->assertOk();
    }
}
