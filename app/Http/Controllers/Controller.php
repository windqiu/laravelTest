<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Validation\ValidationException;

class Controller extends BaseController
{
    use AuthorizesRequests;
    use ValidatesRequests;

    /**
     * Notes: 统一响应格式处理
     * @param $msg
     * @param $code
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     * @author: windqiu
     * @time: 2024/11/1820:37
     */
    public function resultResponse($msg = 'ok', $code = 0, array $data = [])
    {
        return response()->json(
            [
                'code' => $code,
                'msg' => $msg,
                'data' => $data
            ]
        );
    }
}
