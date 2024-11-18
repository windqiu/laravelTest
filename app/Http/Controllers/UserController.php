<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

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
        $isExist = $this->userModel->isExist($username, md5($password));
        if (!$isExist) {
            return $this->resultResponse('用户不存在', -1);
        }
        //查询用户信息
        $userInfo = $this->userModel->getUserInfo($username);
        if (empty($userInfo)) {
            return $this->resultResponse('用户为空', -1);
        }
        //模拟单用户时记录用户信息，设置120s
        Cache::set('user', json_encode($userInfo), 120);
        return $this->resultResponse();
    }
}
