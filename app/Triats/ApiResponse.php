<?php

declare(strict_types=1);

namespace App\Triats;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

trait ApiResponse
{
    use OnResponse;
    use Loggable;

    /**
     * Notes: 成功响应
     * @param string $message
     * @param $data
     * @return JsonResponse
     * @author: windqiu
     * @time: 2024/11/1922:19
     */
    public function successResponse(string $message = '', $data = null): JsonResponse
    {
        return new JsonResponse([
            'timestamp' => now(),
            'status'    => true,
            'message'   => $message,
            'data'      => $data
        ], Response::HTTP_OK);
    }

    /**
     * Notes: 失败响应
     * @param string $statusCode
     * @param string $message
     * @param int $httpCode
     * @return JsonResponse
     * @author: windqiu
     * @time: 2024/11/1922:19
     */
    public function errorResponse(
        string $statusCode,
        string $message = '',
        int $httpCode = Response::HTTP_INTERNAL_SERVER_ERROR
    ): JsonResponse {
        //错误校验信息处理
        $messageArr = json_decode($message, true);
        if (is_array($messageArr)) {
            $message = '';
            foreach ($messageArr as $msg) {
                $message .= implode(',', $msg) . '|';
            }
            $message = rtrim($message, '|');
        }

        return new JsonResponse([
            'timestamp'  => now(),
            'status'     => false,
            'statusCode' => $statusCode,
            'message'    => $message
        ], $httpCode);
    }
}
