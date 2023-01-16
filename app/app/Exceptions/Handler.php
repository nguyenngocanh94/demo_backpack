<?php

namespace App\Exceptions;

use App\Exceptions\Definition\ExceedDrawingException;
use App\Exceptions\Definition\InvalidPointBalanceException;
use Carbon\Carbon;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
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
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        $message = __('something wrong on server, try again!');
        if ($e instanceof ExceedDrawingException){
            $message = __('got max exceed daily lucky drawing');
        }

        if ($e instanceof InvalidPointBalanceException){
            $message = __('insufficient balance');
        }

        $json = [
            'message' => 'fail',
            'result' => [
                'message' => $message
            ],
            'ts' => Carbon::now('UTC')->timestamp
        ];

        return response()->json($json)->setStatusCode(Response::HTTP_BAD_REQUEST);
    }
}
