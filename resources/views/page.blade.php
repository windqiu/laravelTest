<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Bootstrap Material Admin</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="robots" content="all,follow">
    <link rel="stylesheet" href="https://ajax.aspnetcdn.com/ajax/bootstrap/4.2.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ 'Bootstrap/css/style.default.css' }}" id="theme-stylesheet">
    <style>
        table {
            width: 100%;
            table-layout: auto;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
<div class="page login-page">
    <form id="sql-form" method="post">
        <label for="sql-input">SQL语句:</label>
        <input type="text" id="sql-input" name="sql" required>
        <button type="button" id="submitSql">Execute</button>
        <button type="button" id="exportExcel">Export Excel</button>
        <button type="button" id="exportJson">Export Json</button>
    </form>
</div>
<hr>
<div class="container">
    <table>
        <thead>
        <tr>
            <th>用户名</th>
            <th>SQL语句</th>
            <th>执行时间</th>
            <th>执行结果</th>
        </tr>
        </thead>
        <tbody>

        @foreach($data as $sql)
        <tr>
            <td>{{$sql->username}}</td>
            <td>{{$sql->sql}}</td>
            <td>{{$sql->create_at}}</td>
            <td>{{$sql->error}}</td>
        </tr>
        @endforeach
        </tbody>
    </table>
    {{$data->links()}}
</div>
<!-- JavaScript files-->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="{{ 'Bootstrap/js/bootstrap.min.js' }}"></script>
<script src="{{ 'layui/layui.js' }}"></script>
<script>
    $(function(){
        /*提交sql*/
        $("#submitSql").click(function(){
            var sqlInput=$("#sql-input").val();
            if (! checkSql(sqlInput)) {
                //校验sql语句合法性
                return;
            }
            $.post('addSql',{"sql":sqlInput},function(res){
                console.log(res);
                if (!res.status) {
                    alert(res.msg)
                    return;
                }
                location.reload();
            })
        })

        //导出执行sql结果为excel
        $("#exportExcel").click(function(){
            var sqlInput=$("#sql-input").val();
            if (! checkSql(sqlInput)) {
                //校验sql语句合法性
                return;
            }
            $.post('export',{"sql":sqlInput, "type": "excel"},function(res){
                console.log(res);
                // if (!res.status) {
                //     alert(res.message);
                //     return;
                // }

                // var a = document.createElement('a');
                // a.download = res.data.file_name
                // a.href = res.data.path + '/' +res.data.file_name;
                // a.target = '_blank';
                // a.click()
                // location.href = res.data.path + '/' +res.data.file_name;
                // console.log(location.href)
                // const SERVER_PATH = `${window.location.origin}`;
                // const alink = document.createElement('a');
                // alink.style.display = 'none'
                // alink.href = `${SERVER_PATH}` + res.data.path + '/' +res.data.file_name;
                // alink.download = '';
                //
                // document.body.appendChild(alink)
                // alink.click();
                // URL.revokeObjectURL(alink.href) // 释放URL 对象
                // document.body.removeChild(alink)
            })
        })
        //导出执行sql结果为 json
        // $("#exportJson").click(function(){
        //     var sqlInput=$("#sql-input").val();
        //     if (! checkSql(sqlInput)) {
        //         //校验sql语句合法性
        //         return;
        //     }
        //     $.get('export',{"sql":sqlInput, "type": "json"},function(res){
        //         document.createElement('a');
        //     })
        // })
    })

    function checkSql(sqlInput) {
        if (!/^select\s/i.test(sqlInput)) {
            alert('只允许执行SELECT语句！');
            return false;
        }
        return true;
    }
</script>
</body>
</html>
