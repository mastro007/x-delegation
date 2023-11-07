<?php

use App\Domain\Delegation\Api\Controllers\MainController;
use App\Domain\Delegation\Api\Controllers\v1\DelegationController;
use App\Domain\Delegation\Api\Controllers\v1\WorkerController;
use Illuminate\Support\Facades\Route;


Route::prefix('api/v1')
    ->group(function () {
        Route::post('/workers', WorkerController::class)
            ->name('api.workers.store');

        Route::get('/delegations', [DelegationController::class, 'indexAction'])
            ->name('api.delegations.index');

        Route::post('/delegations', [DelegationController::class, 'storeAction'])
            ->name('api.delegations.store');
    });

Route::get('/', MainController::class)
    ->name('api.index');
