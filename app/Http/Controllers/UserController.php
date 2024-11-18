<?php

namespace App\Http\Controllers;

use App\Models\SqlLog;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(private User $userModel)
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
        $username = $request->post('username');
        $password = $request->post('password');
        if (empty($username) || empty($password)) {
            return $this->resultResponse('参数不合法', -1);
        }

        //判断用户是否存在
        $isExists = $this->userModel->isExist($username, md5($password));
        if (!$isExists) {
            return $this->resultResponse('用户不存在', -1);
        }

        return $this->resultResponse();
    }
}
