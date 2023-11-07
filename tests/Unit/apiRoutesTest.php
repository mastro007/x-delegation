<?php

namespace Tests\Unit;

use Tests\TestCase;

class apiRoutesTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_not_existing_route_return_404(): void
    {
        $response = $this->getJson('/api/nonexistsroute');
        $response->assertStatus(404);
    }
}
