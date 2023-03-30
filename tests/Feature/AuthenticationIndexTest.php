<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationIndexTest extends TestCase
{
    use RefreshDatabase;

    public function testUnauthenticatedIndex(): void
    {
        $this->get('/')
            ->assertStatus(302)
            ->assertRedirect('entrada');
    }

    public function testIndexView(): void
    {
        $user = User::factory()
            ->state(['is_enabled' => true])
            ->state(['is_confirmed' => true])
            ->createOne();

        $this->actingAs($user)
            ->get('')
            ->assertOk();
    }
}
