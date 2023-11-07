<?php

namespace App\Domain\Delegation\Providers;

use App\Domain\Delegation\Services\DelegationService;
use App\Domain\Delegation\Services\WorkerService;
use Illuminate\Support\ServiceProvider;


class DelegationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(DelegationService::class, fn() => new DelegationService(
            bonusDays: config('services.delegation.bonus_days'),
            bonusRate: config('services.delegation.bonus_rate'),
            hours: config('services.delegation.hours'),
            currency: config('services.delegation.currency')
        ));

        $this->app->bind(WorkerService::class, fn() => new WorkerService(
            company: config('services.worker.company')
        ));
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../DB/Migrations');
        $this->mergeConfigFrom(__DIR__.'/../Config/services.php', 'services');
    }
}
