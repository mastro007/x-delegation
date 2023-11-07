<?php
declare(strict_types=1);

namespace App\Domain\Delegation\DTO;

use App\Domain\Delegation\Enums\CountryCodeEnum;
use Carbon\Carbon;
use Spatie\LaravelData\Data as DTO;

/**
 * @class DelegationDTO
 * @package \App\Domain\Delegation\DTO\DelegationDTO
 */
class DelegationDTO extends DTO
{
    /**
     * @param string $workerId
     * @param Carbon $start
     * @param Carbon $end
     * @param \App\Domain\Delegation\Enums\CountryCodeEnum $country
     */
    public function __construct(
        readonly string $workerId,
        readonly Carbon $start,
        readonly Carbon $end,
        readonly CountryCodeEnum $country
    )
    {
    }
}
