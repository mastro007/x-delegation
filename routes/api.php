<?php

use Illuminate\Support\Facades\Route;
use App\Http\Api\v1\WorkerController;
use App\Http\Api\v1\DelegationController;
use App\Http\Api\MainController;



Route::prefix('v1')
    ->namespace('\App\Http\Api\v1')
    ->group(function () {
        Route::post('/workers', WorkerController::class)
            ->name('api.workers.store');

        Route::get('/delegations', [DelegationController::class, 'indexAction'])
            ->name('api.delegations.index');

        Route::post('/delegations', [DelegationController::class, 'storeAction'])
            ->name('api.delegations.store');
    });

//
    Route::get('/', MainController::class)
        ->name('api.index');
