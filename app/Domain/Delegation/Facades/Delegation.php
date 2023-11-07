<?php
declare(strict_types=1);

namespace App\Domain\Delegation\Facades;

use App\Domain\Delegation\DTO\DelegationDTO;
use App\Domain\Delegation\Services\DelegationService;
use Illuminate\Support\Facades\Facade;

/**
 * @class  Delegation
 * @package \App\Domain\Delegation\Facades\Delegation
 * @see \App\Domain\Delegation\Services\DelegationService
 * @method static create(DelegationDTO $DTO)
 * @method static fetchAll()
 */
class Delegation extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return DelegationService::class;
    }
}
