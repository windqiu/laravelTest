<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SqlLog extends Model
{
    use HasFactory;

    protected $table = 'sql_log';

    protected $fillable = ['username', 'sql', 'create_at', 'error'];

    /**
     * Notes: 插入sql日志信息
     * @param array $params
     * @return mixed
     * @author: windqiu
     * @time: 2024/11/1819:55
     */
    public function addSql(array $params)
    {
        return $this->insert($params);
    }
}
