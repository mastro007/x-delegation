<?php
declare(strict_types=1);

namespace App\Domain\Delegation\Services;

use App\Domain\Delegation\DTO\DelegationDTO;
use App\Domain\Delegation\Enums\CountryCurrencyEnum;
use App\Domain\Delegation\Exceptions\DelegationException;
use App\Domain\Delegation\Models\Delegation;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Collection;

/**
 * @class DelegationService
 * @package \App\Domain\Delegation\Services\DelegationService
 */
class DelegationService
{

    /**
     * @param int $bonusDays
     * @param int $bonusRate
     * @param int $hours
     * @param string $currency
     * @throws DelegationException
     */
    public function __construct(
        readonly int    $bonusDays,
        readonly int    $bonusRate,
        readonly int    $hours,
        readonly string $currency
    )
    {
        $this->checkConfig();
    }

    /**
     * @throws DelegationException
     */
    private function checkConfig(): void
    {
        foreach (config('services.delegation') as $config) {
            if (is_null($config)) {
                throw DelegationException::invalidConfig();
            }
        }
    }

    /**
     * @return Collection
     * @uses \App\Domain\Delegation\Api\Controllers\v1\DelegationController
     */
    public function fetchAll(): Collection
    {
        return Delegation::all();
    }


    /**
     * @throws DelegationException
     */
    public function create(DelegationDTO $DTO): Delegation
    {
        if ($this->isWorkerDelegated($DTO->workerId, $DTO->start, $DTO->end)) {
            throw DelegationException::workerAlreadyDelegated();
        }

        $delegation = new Delegation();
        $delegation->worker_id = $DTO->workerId;
        $delegation->start = $DTO->start;
        $delegation->end = $DTO->end;
        $delegation->country = $DTO->country;
        $delegation->currency = CountryCurrencyEnum::from($this->currency);
        $delegation->amount_due = $this->calculateAmountDue($DTO);
        $delegation->save();

        return $delegation;
    }

    /**
     * @param \App\Domain\Delegation\DTO\DelegationDTO $delegation
     * @return int
     */
    private function calculateAmountDue(DelegationDTO $delegation): int
    {
        $baseAmountDue = $this->getBaseAmountDue($delegation);
        $extraAmountDue = $this->getExtraAmountDue($delegation);

        return ($baseAmountDue + $extraAmountDue);
    }

    /**
     * @param \App\Domain\Delegation\DTO\DelegationDTO $delegation
     * @return int
     */
    private function getBaseAmountDue(DelegationDTO $delegation): int
    {
        return $this->calculateBaseDiet($delegation);
    }

    /**
     * @param DelegationDTO $delegation
     * @return int
     */
    private function getExtraAmountDue(DelegationDTO $delegation): int
    {
        return $this->calculateExtraDiet($delegation);
    }

    /**
     * @param \App\Domain\Delegation\DTO\DelegationDTO $delegation
     * @return int
     */
    public function calculateBaseDiet(DelegationDTO $delegation): int
    {
        $days = $this->calculateDelegationBaseDaysLength($delegation);
        return $days * $delegation->country->rate();
    }

    /**
     * @param \App\Domain\Delegation\DTO\DelegationDTO $delegation
     * @return int
     */
    public function calculateExtraDiet(DelegationDTO $delegation): int
    {
        $days = $this->calculateDelegationExtraDaysLength($delegation);
        return $days * ($delegation->country->rate() * $this->bonusRate);
    }

    /**
     * @param DelegationDTO $delegation
     * @return int
     */
    public function calculateDelegationExtraDaysLength(DelegationDTO $delegation): int
    {
        $days = 0;
        if ($this->isBonus($delegation)) {
            $start = $delegation->start->copy()->addDays($this->bonusDays)->addDay();
            /* @var Carbon $day */
            foreach ($this->getDateRange($start, $delegation->end) as $day) {
                if ($this->isDayIncluded($day)) {
                    $days++;
                }
            }
        }

        return $days;
    }

    /**
     * @param DelegationDTO $delegation
     * @return bool
     */
    public function isBonus(DelegationDTO $delegation): bool
    {
        if ($delegation->start->diffInDays($delegation->end) > $this->bonusDays) {
            return true;
        }

        return false;
    }

    /**
     * @param DelegationDTO $delegation
     * @return int
     */
    public function calculateDelegationBaseDaysLength(DelegationDTO $delegation): int
    {
        $days = 0;

        /* @var Carbon $day */
        foreach ($this->getDateRange($delegation->start, $delegation->end) as $day) {
            if ($this->isDayIncluded($day)) {
                $days++;
            }
        }

        if ($this->isBonus($delegation)) {
            return $this->bonusDays;
        }

        return $days;
    }

    /**
     * @param Carbon $start
     * @param Carbon $end
     * @return Collection
     */
    public function getDateRange(Carbon $start, Carbon $end): Collection
    {
        return collect(CarbonPeriod::create($start, $end)->toArray());
    }

    /**
     * @param Carbon $date
     * @return bool
     */
    public function isDayIncluded(Carbon $date): bool
    {
        if ($date->diffInHours($this->getStartTime()) >= $this->hours) {
            return true;
        }

        return false;
    }

    /**
     * @return Carbon
     */
    public function getStartTime(): Carbon
    {
        return Carbon::today()
            ->hours(0)
            ->minutes(0)
            ->seconds(0);
    }


    /**
     * @param $workerId
     * @param $start
     * @param $end
     * @return bool
     */
    public function isWorkerDelegated($workerId, $start, $end): bool
    {
        return Delegation::query()
            ->where('worker_id', $workerId)
            ->where(function ($query) use ($start, $end) {
                // Delegacja zaczyna się w okresie
                $query->where(function ($q) use ($start, $end) {
                    $q->where('start', '>=', $start)
                        ->where('start', '<=', $end);
                })
                    // LUB delegacja kończy się w okresie
                    ->orWhere(function ($q) use ($start, $end) {
                        $q->where('end', '>=', $start)
                            ->where('end', '<=', $end);
                    })
                    // LUB delegacja obejmuje cały okres
                    ->orWhere(function ($q) use ($start, $end) {
                        $q->where('start', '<=', $start)
                            ->where('end', '>=', $end);
                    });
            })
            ->exists();
    }
}
