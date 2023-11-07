<?php

namespace App\Domain\Delegation\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

class ResponseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Response::macro('success', function ($data) {
            return Response::json([
                'status' => 'success',
                'data' => $data,
            ], 200);
        });

        Response::macro('error', function (\Exception $exception) {

            $message = 'Coś poszło nie tak';

            if (!App::isProduction()) {
                $message = [
                    'error' => $exception->getMessage(),
                    'file' => $exception->getFile(),
                    'line' => $exception->getLine()
                ];
            }

            return Response::json([
                'status' => 'error',
                'message' => $message,
            ], 500);
        });

        Response::macro('validation', function ($message) {
            return Response::json([
                'status' => 'error',
                'message' => $message
            ], 422);
        });

        Response::macro('notFound', function () {
            return Response::json([
                'status' => 'error',
                'message' => 'Nie znaleziono zasobu'
            ], 404);
        });

        Response::macro('badRequest', function ($message) {
            return Response::json([
                'status' => 'error',
                'message' => $message
            ], 405);
        });

        Response::macro('conflict', function ($message) {
            return Response::json([
                'status' => 'error',
                'message' => $message
            ], 419);
        });


    }
}
