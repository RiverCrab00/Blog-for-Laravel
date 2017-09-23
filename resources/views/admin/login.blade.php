<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style type="text/css">
        #box{
            margin-top: 50px;
            padding:50px 80px 80px 80px;
            border-radius: 10px;
            border: 1px solid #00CC99;
            background: #00CC99;
            height: 250px;
        }
        .input-group{
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
@include('layout/include')
<div id='box' class="col-sm-4 col-sm-offset-4">
<form action="{{url('admin/manager/login')}}" method="post">
    {{csrf_field()}}
    <div class="input-group">
        <span class="input-group-addon"><i class="fa fa-user-o fa-fw"></i></span>
        <input class="form-control input-lg" name='username' type="text" placeholder="Username">
    </div>
    <div class="input-group">
        <span class="input-group-addon"><i class="fa fa-key fa-fw"></i></span>
        <input class="form-control input-lg" name="password" type="password" placeholder="Password">
    </div>
    <div class="text-center">
        <button class="button button-action button-rounded"><i class="fa fa-home"></i>登录</button>
    </div>
</form>
</div>
</body>
</html>