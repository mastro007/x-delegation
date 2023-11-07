<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WorkerControllerTest extends TestCase
{

    use RefreshDatabase;

    public function test_can_create_worker(): void
    {
        $response = $this->postJson('/api/v1/workers');
        $response->assertSuccessful();
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            'data' =>[
                'id',
                'company'
            ]
        ]);
        $this->assertDatabaseHas('workers', ['id' => $response->json()['data']['id']]);
        $this->assertDatabaseHas('workers', ['company' => $response->json()['data']['company']]);

    }

    public function test_can_return_bad_request()
    {
        $response = $this->putJson('/api/v1/workers');
        $response->assertStatus(405);
    }
}
