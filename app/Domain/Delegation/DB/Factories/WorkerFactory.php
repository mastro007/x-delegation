<?php

namespace App\Domain\Delegation\DB\Factories;

use App\Domain\Delegation\Models\Worker;
use Illuminate\Database\Eloquent\Factories\Factory;
use Worker as WorkerService;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Domain\Delegation\Models\Worker>
 */
class WorkerFactory extends Factory
{
    protected $model = Worker::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => WorkerService::generateId(),
            'company' => fake()->company
        ];
    }
}
