<?php

namespace App\Providers;

use App\Domain\Delegation\Services\DelegationService;
use App\Domain\Delegation\Services\WorkerService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->registerFacades();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }

    private function registerFacades(): void
    {

    }
}
