<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MainControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_can_main_response_successfuly(): void
    {
        $response = $this->get(route('api.index'));
        $response->assertSuccessful();
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            'data' => [
                'message',
                'version',
                'server_time'
            ]
        ]);
    }
}
