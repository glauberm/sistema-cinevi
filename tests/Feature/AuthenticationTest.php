<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
}
