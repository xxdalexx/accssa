<?php

namespace App\Exceptions;

use Throwable;
use App\Models\User;
use ReflectionClass;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    public function report(Throwable $exception)
    {
        if (env('APP_ENV') == "production") {
            $message = $exception->getMessage();
            $file = $exception->getFile();
            $line = $exception->getLine();
            User::first()->sendDiscordDM("Error: " . $message . " - File: " . $file . " - Line: " . $line);
        }
    }
}
