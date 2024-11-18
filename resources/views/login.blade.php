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
    <div class="container d-flex align-items-center">
        <div class="form-holder has-shadow">
            <div class="row">
                <!-- Logo & Information Panel-->
                <div class="col-lg-6">
                    <div class="info d-flex align-items-center">
                        <div class="content">
                            <div class="logo">
                                <h1>欢迎登录</h1>
                            </div>
                            <p>laravel初体验</p>
                        </div>
                    </div>
                </div>
                <!-- Form Panel    -->
                <div class="col-lg-6 bg-white">
                    <div class="form d-flex align-items-center">
                        <div class="content">
                            <form method="post" action="" class="form-validate" id="loginFrom">
                                <div class="form-group">
                                    <input id="login-username" type="text" name="username" required data-msg="请输入用户名" placeholder="用户名"  class="input-material">
                                </div>
                                <div class="form-group">
                                    <input id="login-password" type="password" name="passWord" required data-msg="请输入密码" placeholder="密码" class="input-material">
                                </div>
                                <input type="button" id="login" class="btn btn-primary" value="登录" >
                            </form>
                            <br />
{{--                            <small>没有账号?</small><a href="register" class="signup">&nbsp注册</a>--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- JavaScript files-->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="{{ 'Bootstrap/js/bootstrap.min.js' }}"></script>
<script src="{{ 'layui/layui.js' }}"></script>
<script>
    $(function(){
        /*登录*/
        $("#login").click(function(){
            var username=$("#login-username").val();
            var passWord=$("#login-password").val();
            $.post('login',{"username":username,"password":passWord},function(res){
                //为避免layui与bootstrap冲突
                // console.log(res);
                //json转换为对象
                console.log(res);
                if(res.code == -1){
                    alert(res.msg);
                } else {
                    //跳转到 index页面
                    window.location.href = 'page';
                }
            })
        })
    })
</script>
</body>
</html>
