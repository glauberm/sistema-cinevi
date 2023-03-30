<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Mail\UserPendingApprovalMail;
use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class AuthenticationFinalizeRegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function testFinalizeRegistration(): void
    {
        Mail::fake();

        User::factory()
            ->state(['is_enabled' => true])
            ->state(['is_confirmed' => true])
            ->state(['roles' => [UserRole::Department]])
            ->count(2)
            ->create();

        $user = User::factory()
            ->state(['is_enabled' => false])
            ->state(['is_confirmed' => false])
            ->createOne();

        $url = URL::temporarySignedRoute(
            'authentication.finalize-registration',
            CarbonImmutable::now()->addMinutes(60),
            ['id' => $user->id]
        );

        $this->get($url)
            ->assertStatus(302)
            ->assertRedirect('entrada');

        Mail::assertQueued(UserPendingApprovalMail::class, 2);
    }
}
