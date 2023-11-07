<?php
declare(strict_types=1);

namespace App\Domain\Delegation\Enums;

enum CountryCodeEnum: string
{
    case PL = 'PL';
    case DE = 'DE';
    case GB = 'GB';

    /**
     * @return int
     */
    public function rate(): int
    {
        return match ($this) {
            CountryCodeEnum::PL => CountryRateEnum::PL->value,
            CountryCodeEnum::DE => CountryRateEnum::DE->value,
            CountryCodeEnum::GB => CountryRateEnum::GB->value
        };
    }
}
