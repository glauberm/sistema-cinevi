<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;

class WebTest extends TestCase
{
    /**
     * Testa a renderização da página raiz.
     *
     * @return void
     */
    public function testWeb()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
