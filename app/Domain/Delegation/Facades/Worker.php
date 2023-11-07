<?php
declare(strict_types=1);

namespace App\Domain\Delegation\Facades;

use App\Domain\Delegation\Services\WorkerService;
use Illuminate\Support\Facades\Facade;

/**
 * Class Worker
 * @package \App\Domain\Delegation\Facades\Worker
 * @see \App\Domain\Delegation\Services\WorkerService
 * @method static generateId()
 */
class Worker extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return WorkerService::class;
    }
}
