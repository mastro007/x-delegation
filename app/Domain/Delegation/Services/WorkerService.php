<?php
declare(strict_types=1);

namespace App\Domain\Delegation\Services;

use App\Domain\Delegation\Models\Worker;
use Illuminate\Support\Str;

/**
 * Class WorkerService
 * @package \App\Domain\Delegation\Services\WorkerService
 */
class WorkerService
{
    public function __construct(
        readonly string $company
    )
    {
    }

    /**
     * @return string
     */
    public function generateId(): string
    {
        return Str::random(config('services.worker.id_length'));
    }

    /**
     * @return Worker
     */
    public function create(): Worker
    {
        $newWorker = new Worker();
        $newWorker->id = $this->generateId();
        $newWorker->company = config('services.worker.company');
        $newWorker->save();

        return $newWorker;
    }
}
