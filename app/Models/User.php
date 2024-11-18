<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class User extends Model
{
    protected $table = 'users';
    /**
     * Notes: 查询用户是否存在
     * @param string $username 用户名
     * @param string $password 密码
     * @return bool
     * @author: windqiu
     * @time: 2024/11/1813:17
     */
    public function isExist(string $username, string $password): bool
    {
        return $this->where(['username' => $username, 'password' => $password])->exists();
    }

    /**
     * Notes: 获取用户信息
     * @param $username
     * @return array
     * @author: windqiu
     * @time: 2024/11/1813:18
     */
    public function getUserInfo($username): array
    {
        $info = $this->where('username', $username)->firstWhere('username', $username);
        return $info->toArray();
    }
}
