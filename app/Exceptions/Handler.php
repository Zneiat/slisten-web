<?php

namespace Slisten\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\UnauthorizedException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof \HttpException) {
            $httpCode = $exception->getStatusCode();
            $situations = [
                404 => [
                    'title' => 'Page Not Found',
                    'msg'   => ' (;ﾟДﾟi|!)  迷失在了暗黑之林...'
                ],
                403 => [
                    'title' => 'Forbidden',
                    'msg'   => '(ﾉﾟ∀ﾟ)ﾉ 哎呀... 无权访问...'
                ],
                500 => [
                    'title' => 'Internal Server Error',
                    'msg'   => '(▼ヘ▼#) 程序意外地生气啦...'
                ],
            ];
    
            if (!empty($situations[$httpCode]))
                return response()->view('error', $situations[$httpCode], $httpCode);
        }
        
        return parent::render($request, $exception);
    }
}
