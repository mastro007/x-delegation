<?php

namespace App\Exceptions;

use App\Domain\Delegation\Exceptions\DelegationException;
use BadMethodCallException;
use Error;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {

        $this->renderable(function (
            Error|QueryException|BadMethodCallException $exception) {
            return Response::error($exception);
        });

        $this->renderable(function (ValidationException $exception) {
            return Response::validation($exception->getMessage());
        });

        $this->renderable(function (NotFoundHttpException $exception) {
            return Response::notFound();
        });

        $this->renderable(function (MethodNotAllowedHttpException $exception) {
            return Response::badRequest($exception->getMessage());
        });

        $this->renderable(function (DelegationException $exception) {
            return Response::conflict($exception->getMessage());
        });
    }

    public function render($request, Throwable $e)
    {
        return parent::render($request, $e); // TODO: Change the autogenerated stub
    }
}
