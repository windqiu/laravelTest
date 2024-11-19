<?php

namespace App\Http\Logic;

use App\Common\Constants\ExportHeaderConstants;
use App\Exceptions\BizException;
use App\Models\SqlLog;
use App\Utils\ExportExcel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Maatwebsite\Excel\Facades\Excel;
use Throwable;

class LogLogic
{
    private SqlLog $sqlLogModel;
    public function __construct()
    {
        $this->sqlLogModel = new SqlLog();
    }

    /**
     * Notes: 通过分页器获取sqlLog的记录
     * @return mixed
     * @author: windqiu
     * @time: 2024/11/1915:37
     */
    public function getListPaginate()
    {
        return $this->sqlLogModel->paginate(10);
    }

    /**
     * Notes: 提交sql数据
     * @param Request $request
     * @author: windqiu
     * @time: 2024/11/1820:12
     */
    public function submitSql(array $params, array $user)
    {
        $sql = trim($params['sql']);
        if (!str_contains(strtolower($sql), 'select')) {
            throw new BizException('非select sql不被允许', -1);
        }

        $record = [
            'username' => $user['username'] ?? 'unknown',
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
    }

    /**
     * Notes: 提交sql数据
     * @param Request $request
     * @author: windqiu
     * @time: 2024/11/1820:12
     */
    public function exportSql(array $params, array $user)
    {
        //方案1：提交任务式导出，快速响应客户端并异步处理导出任务。
        //方案2：先查询总条数，再处理是否异步处理。
        $sql = trim($params['sql'] ?? '');
        if (!str_contains(strtolower($sql), 'select')) {
            throw new BizException('非select sql不被允许', -1);
        }

        $record = [
            'username' => $user['username'] ?? 'unknown',
            'sql' => $sql,
            'create_at' => date('Y-m-d H:i:s'),
            'error' => 'success'
        ];
        try {
            DB::select($sql);
        } catch (Exception $e) {
            $record['error'] = $e->getMessage();
        }
        $fileName = 'sql_' . time() .  '.xlsx';

        //处理json类型导出
        if ($params['type'] == 'json') {
            $fileName = 'sql_' . time() .  '.json';
            $json = json_encode($record, JSON_PRETTY_PRINT);

            return Response::make($json, 200, [
            'Content-Type' => 'application/json',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
            ]);
        }
        //处理excel类型导出
        return Excel::download(
            new ExportExcel($record, ExportHeaderConstants::EXPORT_EXCEL_HEADER),
            $fileName,
            \Maatwebsite\Excel\Excel::XLSX
        );
    }
}
