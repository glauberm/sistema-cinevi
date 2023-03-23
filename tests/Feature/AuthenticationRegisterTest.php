<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Mail\AuthenticationFinalizeRegistrationMail;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class AuthenticationRegisterTest extends TestCase
{
    public function testRegisterView()
    {
        $this->get('cadastro')
            ->assertOk();
    }

    public function testRegister()
    {
        Mail::fake();

        $this->post('cadastro', [
            'name' => 'Glauber Mota',
            'identifier' => '123456789',
            'phone' => '21997963685',
            'email' => 'glaubernm@gmail.com',
            'password' => 'Gl@uberM0ta7!'
        ])
            ->assertStatus(302)
            ->assertRedirect('entrada');

        Mail::assertQueued(AuthenticationFinalizeRegistrationMail::class);
    }
}
