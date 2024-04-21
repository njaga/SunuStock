<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use BadMethodCallException;
use Throwable;

class Handler extends ExceptionHandler
{
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof NotFoundHttpException) {
            return response()->view('errors.404', [], 404);
        } elseif ($exception instanceof BadMethodCallException) {
            return response()->view('errors.badmethod', [], 500);
        }

        return parent::render($request, $exception);
    }

    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    public function shouldReport(Throwable $exception)
    {
        return parent::shouldReport($exception);
    }
}
