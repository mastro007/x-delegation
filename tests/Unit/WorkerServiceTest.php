<?php

namespace Tests\Unit;

use App\Domain\Delegation\Models\Worker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

/**
 * @class WorkerServiceTest
 * @package \Tests\Unit\WorkerServiceTest
 */
class WorkerServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_worker_id_generate_correctly(): void
    {
        Config::set('services.worker.id_length', 10);
        $worker = Worker::factory()->create();
        $this->assertTrue(10 === strlen($worker->id));
    }

    public function test_can_default_it_length_working_correctly(): void
    {
        $worker = Worker::factory()->create();
        $this->assertTrue(Config::get('services.worker.id_length') === strlen($worker->id));
    }
}
