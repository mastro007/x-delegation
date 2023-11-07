<?php

namespace Tests\Unit;

use App\Domain\Delegation\DTO\DelegationDTO;
use App\Domain\Delegation\Enums\CountryCodeEnum;
use App\Domain\Delegation\Exceptions\DelegationException;
use App\Domain\Delegation\Models\Worker;
use App\Domain\Delegation\Services\DelegationService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class DelegationServiceTest extends TestCase
{
    use RefreshDatabase;

    protected DelegationService $delegationService;
    protected array $config;

    /**
     * @throws \App\Domain\Delegation\Exceptions\DelegationException
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->config = [
            'bonus_days' => 7,
            'bonus_rate' => 2,
            'hours' => 8,
            'currency' => 'PLN'
        ];


        $this->delegationService = new DelegationService(
            $this->config['bonus_days'],
            $this->config['bonus_rate'],
            $this->config['hours'],
            $this->config['currency']
        );
    }

    public function test_base_amount_due()
    {
        $worker = Worker::factory()->create();
        $start = Carbon::now()->hours(8);
        $end = Carbon::now()->hours(12)->addDays(5);
        $country = CountryCodeEnum::PL;

        $value = $this->delegationService->calculateBaseDiet(
            new DelegationDTO(
                workerId: $worker->id,
                start: $start,
                end: $end,
                country: $country
            )
        );

        $this->assertTrue($value === 60);
    }

    public function test_extra_amount_due()
    {
        $worker = Worker::factory()->create();
        $start = Carbon::now()->hours(8);
        $end = Carbon::now()->hours(12)->addDays(20);
        $country = CountryCodeEnum::DE;

        $value = $this->delegationService->calculateExtraDiet(
            new DelegationDTO(
                workerId: $worker->id,
                start: $start,
                end: $end,
                country: $country
            )
        );

        $this->assertTrue($value === 1400);
    }

    public function test_bonus_is_not_included()
    {
        $worker = Worker::factory()->create();
        $start = Carbon::now()->hours(8);
        $end = Carbon::now()->hours(12)->addDays(7);
        $country = CountryCodeEnum::DE;

        $value = $this->delegationService->calculateExtraDiet(
            new DelegationDTO(
                workerId: $worker->id,
                start: $start,
                end: $end,
                country: $country
            )
        );

        $this->assertTrue(0 === $value);
    }
}
