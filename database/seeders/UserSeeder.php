<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Notes: 初始化用户登录信息
     * @return void
     * @author: windqiu
     * @time: 2024/11/1820:50
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'username' => 'admin',
            'password' => md5('123456'),
        ]);
    }
}
