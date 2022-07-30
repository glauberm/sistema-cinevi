<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;

class HealthCheckTest extends TestCase
{
    /**
     * Testa o redirecionamento da raiz da API.
     *
     * @return void
     */
    public function testHealthCheck()
    {
        $response = $this->get('/api');

        $response->assertStatus(301);
    }
}
