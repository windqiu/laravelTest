<?php

namespace App\Exceptions;

use App\Triats\ApiResponse;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
use Throwable;

class Handler extends ExceptionHandler
{
    use ApiResponse;
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
    }

    public function render($request, Throwable $e)
    {
        Log::channel('errorlog')->error($e->getMessage(), [
            'code'    => $e->getCode(),
            'message' => $e->getMessage(),
            'file'    => $e->getFile(),
            'line'    => $e->getLine(),
            //  'trace'   => $e->getTrace(),
        ]);
        return $this->errorResponse('error', $e->getTraceAsString());
    }
}
