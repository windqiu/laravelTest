<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
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
    }

    public function render($request, Throwable $e)
    {
        $response = [
            'code' => -1,
            'msg' => $e->getMessage(),
            'data' => [],
        ];

        // 如果是生产环境，可以隐藏详细的错误信息
        if (app()->isProduction()) {
            $response['msg'] = '服务器内部错误，请稍后再试。';
        }
        Log::channel('errorlog')->error($e->getMessage());
        return response()->json($response);
    }
}
