<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
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

    private $lang_path = 'api/common.';
    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     *
     * @throws \Exception
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
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Exception
     */
    public function render($request, Exception $exception)
    {
        return parent::render($request, $exception);
    }


    /**

     * Convert an authentication exception into an unauthenticated response.

     *

     * @param  \Illuminate\Http\Request  $request

     * @param  \Illuminate\Auth\AuthenticationException  $exception

     * @return \Illuminate\Http\Response

     */

    protected function unauthenticated($request, AuthenticationException $exception)

    {

        if ($request->expectsJson()) {
            $response = [
                'status' => 0,
                'message' => trans($this->lang_path . 'invalid_token'),
                'data' => array()
            ];

            return response()->json($response, 401);
        }

        return redirect()->guest('login');
    }
}
