<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;

class SanctumTest extends TestCase
{
    /**
     * Testa o redirecionamento da raiz da API.
     *
     * @return void
     */
    public function testSanctum()
    {
        $response = $this->get('/sanctum/csrf-cookie');

        $response->assertStatus(204);
    }
}
