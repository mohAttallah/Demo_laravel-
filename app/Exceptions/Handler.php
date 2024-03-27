<?php

namespace App\Exceptions;
use Illuminate\Database\QueryException;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
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
        $this->reportable(function (Throwable $e) {
            //
        });
    }


public function render($request, Throwable $exception)
{
    if ($exception instanceof QueryException) {
        if ($exception->errorInfo[1] == 23505) {
            return response()->json(['error' => 'A user with this email already exists.'], 409);
        }
    }

    if ($request->expectsJson()) {
        return response()->json(['error' => $exception->getMessage()], 500);
    }

    return parent::render($request, $exception);
}
}
