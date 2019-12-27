<?php

namespace VnCoder\Core\Exceptions;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Barryvdh\Debugbar\Facade as Debugbar;

class VnExceptions extends ExceptionHandler
{
    protected $dontReport = [
        HttpException::class,
        ModelNotFoundException::class,
    ];

    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    public function render($request, Exception $exception)
    {
        if ($exception instanceof NotFoundHttpException) {
            \Debugbar::disable();
            return response(view("core::404"), 404);
        }
        return parent::render($request, $exception);
    }
}
