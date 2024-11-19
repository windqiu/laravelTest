<?php

namespace App\Http\Controllers;

use App\Http\Logic\UserLogic;
use App\Models\User;
use App\Triats\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    use ApiResponse;

    public function __construct(private UserLogic $userLogic)
    {
    }

    /**
     * Notes: 展示登录页
     * @author: windqiu
     * @time: 2024/11/1813:14
     */
    public function index()
    {
        return view('login');
    }

    /**
     * Notes: 登录信息提交
     * @param Request $request
     * @author: windqiu
     * @time: 2024/11/1813:14
     */
    public function login(Request $request)
    {
        $params = $request->all();
        $validator = Validator::make($params, [
            'username' => 'required',
            'password' => 'required'
        ], [
            'username.required' => 'username参数必传',
            'password.required' => 'password参数必传',
        ]);
        if ($validator->fails()) {
            return $this->errorResponse('sql log params error', $validator->messages());
        }

        $this->userLogic->loginUser($params);
        return $this->resultResponse();
    }
}
