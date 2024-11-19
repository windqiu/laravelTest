<?php

namespace App\Http\Controllers;

use App\Http\Logic\LogLogic;
use App\Triats\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LogController extends Controller
{
    use ApiResponse;

    private LogLogic $logLogic;
    public function __construct()
    {
        $this->logLogic = new LogLogic();
    }

    /**
     * Notes: 展示 index 页面
     * @param Request $request
     * @author: windqiu
     * @time: 2024/11/1820:12
     */
    public function page()
    {
        $res = $this->logLogic->getListPaginate();
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
        $params = $request->all();
        $validator = Validator::make($params, [
            'sql' => 'required',
        ], [
            'sql.required' => 'sql参数必传',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('sql log params error', $validator->errors()->all()[0]);
        }
        //验证参数
        $this->logLogic->submitSql($params, $request->userInfo);
        return $this->successResponse('sql提交成功');
    }

    /**
     * Notes: 提交sql数据
     * @param Request $request
     * @author: windqiu
     * @time: 2024/11/1820:12
     */
    public function exportSql(Request $request)
    {
        $params = $request->all();
        $validator = Validator::make($params, [
            'sql' => 'required',
            'type' => 'required|in:json,excel'
        ], [
            'type.required' => 'type参数必传',
            'type.in' => 'type导出类型错误',
            'sql.required' => 'sql参数必传',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('sql log params error', $validator->messages());
        }
        //验证参数，导出文件类型与sql
        $res = $this->logLogic->exportSql($params, $request->userInfo);
        return $res;
    }
}
