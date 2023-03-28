<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\BookableCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookableCategoryTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex()
    {
        $user = User::factory()
            ->state(['is_enabled' => true])
            ->state(['is_confirmed' => true])
            ->createOne();

        BookableCategory::factory()
            ->count(11)
            ->create();

        $this->actingAs($user)
            ->get('categorias-de-reservaveis')
            ->assertOk();
    }

    public function testCreateView()
    {
        $user = User::factory()
            ->state(['is_enabled' => true])
            ->state(['is_confirmed' => true])
            ->createOne();

        $this->actingAs($user)
            ->get('categorias-de-reservaveis/adicionar')
            ->assertOk();
    }

    public function testCreate()
    {
        $user = User::factory()
            ->state(['is_enabled' => true])
            ->state(['is_confirmed' => true])
            ->state(['roles' => [UserRole::Admin]])
            ->createOne();

        $this->actingAs($user)
            ->post('categorias-de-reservaveis/adicionar', [
                'title' => 'Lorem Ipsum',
                'description' => 'Lorem Ipsum Dolor Sit Amet',
            ])
            ->assertStatus(302)
            ->assertRedirect('categorias-de-reservaveis');

        $this->assertDatabaseHas('bookable_categories', [
            'title' => 'Lorem Ipsum',
            'description' => 'Lorem Ipsum Dolor Sit Amet',
        ]);
    }

    public function testUpdateView()
    {
        $user = User::factory()
            ->state(['is_enabled' => true])
            ->state(['is_confirmed' => true])
            ->createOne();

        $bookableCategory = BookableCategory::factory()->createOne();

        $this->actingAs($user)
            ->get("categorias-de-reservaveis/{$bookableCategory->id}/editar")
            ->assertOk();
    }
}
