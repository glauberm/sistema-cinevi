<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Configuration;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ConfigurationTest extends TestCase implements HasVersionsTestInterface
{
    use RefreshDatabase, HasVersionsTestTrait;

    protected string $modelClass = Configuration::class;

    protected string $baseApiUrl = 'api/configuracoes';

    protected string $tableName = 'configurations';

    protected function showSanctumActingAs(): void
    {
        Sanctum::actingAs(User::factory()->createOne());
    }

    protected function updateSanctumActingAs(): void
    {
        Sanctum::actingAs(User::factory()->createOne());
    }

    /**
     * @return array<string,mixed>
     */
    protected function getUpdateRequest(): array
    {
        return [
            'bookings_are_closed' => false,
            'bookings_forbidden_dates' => [
                [
                    'month' => '01',
                    'day' => '01',
                    'name' => 'Dia da Confraternização Universal',
                ],
            ],
            'bookings_create_or_update_emails' => [
                'glaubernm@gmail.com',
                'glaubernm@gmail.com',
            ],
            'final_copies_confirmation_message' => 'Lorem Ipsum Dolor Sit Amet',
            'final_copies_create_emails' => [
                'glaubernm@gmail.com'
            ],
            'final_copies_confirmed_emails' => [
                'glaubernm@gmail.com',
                'glaubernm@gmail.com',
                'glaubernm@gmail.com'
            ],
        ];
    }

    /**
     * @return array<string,mixed>
     */
    protected function getUpdateDatabaseFields(): array
    {
        return [
            'bookings_are_closed' => false,
            'final_copies_confirmation_message' => 'Lorem Ipsum Dolor Sit Amet',
        ];
    }

    /**
     * Testa a exibição.
     *
     * @return void
     */
    public function testShow(): void
    {
        $this->showSanctumActingAs();

        $model = $this->modelClass::factory()->create();

        $response = $this->json('GET', "{$this->baseApiUrl}/{$model->id}");

        $response->assertJson(['data' => ['id' => $model->id]]);
    }

    /**
     * Testa a edição.
     *
     * @return void
     */
    public function testUpdate(): void
    {
        $this->updateSanctumActingAs();

        $model = $this->modelClass::factory()->create();

        $response = $this->json('PUT', "{$this->baseApiUrl}/{$model->id}/editar", $this->getUpdateRequest());

        $response->assertOk();

        $this->assertDatabaseHas($this->tableName, $this->getUpdateDatabaseFields());

        if ($this instanceof HasVersionsTestInterface) {
            $this->assertDatabaseHas('versions', ['action' => 'update']);
        }
    }
}
