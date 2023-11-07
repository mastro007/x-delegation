<?php

namespace App\Domain\Delegation\DB\Factories;

use App\Domain\Delegation\Enums\CountryCodeEnum;
use App\Domain\Delegation\Enums\CountryCurrencyEnum;
use App\Domain\Delegation\Models\Delegation;
use App\Domain\Delegation\Models\Worker;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Domain\Delegation\Models\Delegation>
 */
class DelegationFactory extends Factory
{
    protected $model = Delegation::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $start = Carbon::now()->subDays(rand(1, 365));

        return [
            'worker_id' => Worker::factory()->create()->id,
            'start' => $start->toDateTimeString(),
            'end' => $start->copy()->addDays(rand(1, 7))->toDateTimeString(),
            'amount_due' => rand(10,1000),
            'currency' => CountryCurrencyEnum::PLN->value,
            'country' => CountryCodeEnum::PL->value
        ];
    }
}
