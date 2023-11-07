<?php

namespace Tests\Unit;

use App\Domain\Delegation\DTO\DelegationDTO;
use App\Domain\Delegation\Enums\CountryCodeEnum;
use App\Domain\Delegation\Models\Worker;
use Carbon\Carbon;
use Tests\TestCase;

class DelegationDTOTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_object_create_correctly(): void
    {
        $worker = Worker::factory()->create();
        $start = Carbon::now();
        $end = Carbon::now()->addDays(7);
        $country = CountryCodeEnum::PL;

        $DTO = new DelegationDTO(
            $worker->id,
            $start,
            $end,
            $country
        );

        $this->assertTrue($worker->id === $DTO->workerId);
        $this->assertTrue($start === $DTO->start);
        $this->assertTrue($end === $DTO->end);
        $this->assertTrue($country === $DTO->country);
    }
}
