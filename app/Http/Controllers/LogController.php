<?php

namespace App\Http\Controllers;

use App\Models\SqlLog;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class LogController extends Controller
{
    private $user;
    public function __construct(private SqlLog $sqlLogModel)
    {
        $userInfoJson = Cache::get('user');
        $this->user = json_decode($userInfoJson, true);
    }

    /**
     * Notes: 展示 index 页面
     * @param Request $request
     * @author: windqiu
     * @time: 2024/11/1820:12
     */
    public function page(Request $request)
    {
        $res = $this->sqlLogModel->paginate(10);
        return view('page', ['data' => $res]);
    }

    /**
     * Notes: 提交sql数据
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @author: windqiu
     * @time: 2024/11/1820:12
     */
    public function submitSql(Request $request)
    {
        $sql = $request->post('sql');
        if (empty($sql) || !str_contains(strtolower($sql), 'select')) {
            return $this->resultResponse('sql为空或 非select sql不被允许', -1);
        }

        $record = [
            'username' => $this->user['username'] ?? 'unknown',
            'sql' => $sql,
            'create_at' => date('Y-m-d H:i:s'),
            'error' => 'success'
        ];
        try {
            DB::select($sql);
        } catch (Exception $e) {
            $record['error'] = $e->getMessage();
        } finally {
            $this->sqlLogModel->addSql($record);
        }
        return $this->resultResponse('sql提交成功');
    }
}
