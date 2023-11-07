<?php

namespace App\Domain\Delegation\Api\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @class DelegationResource
 * @package \App\Domain\Delegation\Api\Resources\DelegationResource
 * @property Carbon $start
 * @property Carbon $end
 * @property string $country
 * @property integer $amount_due
 * @property string $currency
 */
class DelegationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'start' => Carbon::parse($this->start)->toDateTimeString(),
            'end' => Carbon::parse($this->end)->toDateTimeString(),
            'country' => $this->country,
            'amount_due' => $this->amount_due,
            'currency' => $this->currency
        ];
    }
}
