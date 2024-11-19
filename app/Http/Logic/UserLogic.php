<?php

namespace App\Http\Logic;

use App\Common\Constants\ExportHeaderConstants;
use App\Exceptions\BizException;
use App\Models\SqlLog;
use App\Models\User;
use App\Utils\ExportExcel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Maatwebsite\Excel\Facades\Excel;
use Throwable;

class UserLogic
{
    private User $userModel;
    public function __construct()
    {
        $this->userModel = new User();
    }

    /**
     * Notes: 用户登录信息
     * @param Request $request
     * @author: windqiu
     * @time: 2024/11/1820:12
     */
    public function loginUser(array $params)
    {
        $username = data_get($params, 'username', '');
        $password = data_get($params, 'password', '');
        //判断用户是否存在
        $isExist = $this->userModel->isExist($username, md5($password));
        if (!$isExist) {
            throw new BizException('用户不存在', -1);
        }
        //查询用户信息
        $userInfo = $this->userModel->getUserInfo($username);
        if (empty($userInfo)) {
            throw new BizException('用户为空', -1);
        }
        //模拟单用户时记录用户信息，设置120s
        Cache::set('user', json_encode($userInfo), 7200);
    }
}
