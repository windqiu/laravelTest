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
</head>
<body>
<div class="page login-page">
    <form id="sql-form" method="post">
        <label for="sql-input">SQL语句:</label>
        <input type="text" id="sql-input" name="sql" required>
        <button type="button" id="submitSql">Execute</button>
    </form>
</div>
<hr>
<div class="container">
    <ul>
        @foreach($data as $sql)
            <li>用户名：{{$sql->username}}, SQL语句：{{$sql->sql}}, 执行时间：{{$sql->create_at}}, 执行信息：{{$sql->error}}</li>
        @endforeach
    </ul>

</div>
{{$data->links()}}
<!-- JavaScript files-->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="{{ 'Bootstrap/js/bootstrap.min.js' }}"></script>
<script src="{{ 'layui/layui.js' }}"></script>
<script>
    $(function(){
        /*提交sql*/
        $("#submitSql").click(function(){
            var sqlInput=$("#sql-input").val();
            if (!/^select\s/i.test(sqlInput)) {
                alert('只允许执行SELECT语句！');
                return;
            }
            $.post('addSql',{"sql":sqlInput},function(res){
                console.log(res);
                if (res.code != 0) {
                    alert(res.msg)
                    return;
                }
                location.reload();
            })
        })
    })
</script>
</body>
</html>
