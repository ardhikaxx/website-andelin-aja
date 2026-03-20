<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function test_the_application_shows_the_welcome_landing_page(): void
    {
        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('Operasional Andelin Aja');
    }
}