@extends('layout.layout')

<link href="{{asset('Home')}}/css/bootstrap.css" rel="stylesheet" type="text/css" />

<style type="text/css">
    .regex{
        line-height: 30px;
    }
    #captcha{
        width: 120px;
        border-radius:10px ;
    }
    #sendMsg{
        margin-top: 2px;
        width: 60px;
        height: 32px;
    }
    h4{
        display:inline;
    }
</style>
@section('content')
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="product-content-right">
                        <div class="woocommerce">
                            <form class="form-horizontal" action="{{url('home/member/register')}}" method="post">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">用户名</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" placeholder="请输入用户名" name='name'>
                                    </div>
                                    <span class='regex'></span>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">密码</label>
                                    <div class="col-sm-4">
                                        <input type="password" class="form-control" placeholder="请输入密码"name='passwd'>
                                    </div>
                                    <span class='regex'></span>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">确认密码</label>
                                    <div class="col-sm-4">
                                        <input type="password" class="form-control" placeholder="请再次输入密码" name='re-passwd'>
                                    </div>
                                    <span class='regex'></span>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">手机号</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" placeholder="请输入手机号" name="tel">
                                    </div>
                                    <span class='regex'></span>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">短信验证码</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" placeholder="请输入短信验证码" name="sms_code">
                                    </div>

                                    <div>
                                        <button type="button" id='sendMsg' title="点击发送短信" class="btn btn-primary"><i class="fa fa-envelope fa-1x"></i></button>
                                        <span class='regex'></span>
                                    </div>

                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">验证码</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" placeholder="请输入验证码" name='code'>
                                    </div>
                                    <img src="{{url('home/member/captcha')}}" id='captcha'>
                                    <span class='regex'></span>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-4">
                                        <input type="submit" class="btn btn-primary" value="注册新用户">
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    <script type="text/javascript">
        $('#sendMsg').click(function(){
            var tel=$("[name='tel']").val();
            $('#sendMsg').attr('disabled',true);
            nums=60;
            clock = setInterval(doLoop, 1000);
            $.ajax({
                'url': "{{url('home/member/sendSms')}}",
                'data':{'phone':tel},
                'dataType':'json',
                'type':'post',
                'headers':{'X-CSRF-TOKEN':'{{csrf_token()}}'},
                'success':function (msg) {
                    if(msg.info){
                        layer.msg('发送成功,请注意查收',{
                            'icon':6,
                            'time':1000
                        });
                    }else{
                        layer.alert('内容',{
                            'icon':5,
                        })
                    }
                }
            });
        })
        function doLoop()
        {
            nums--;
            if(nums > 0){
               $('#sendMsg').html(nums);
               $('#sendMsg').attr('title',nums+'秒后重新发送');
            }else{
                clearInterval(clock); //清除js定时器
                $('#sendMsg').attr('disabled',false);
                $('#sendMsg').attr('title','点击重新发送');
                $('#sendMsg').html('<i class="fa fa-envelope fa-1x"></i>');
            }
        }
        $("[name='sms_code']").blur(function(){
            var code=$(this).val();
            var span=$(this).parent().parent().find('span');
            $.ajax({
                'url':"{{url('home/member/checkSms')}}",
                'data':{'code':code},
                'dataType':'json',
                'type':'post',
                'headers':{'X-CSRF-TOKEN':'{{csrf_token()}}'},
                'success':function(msg){
                    if(msg.info){
                        span.html("<h4><i class='fa fa-check' style='color:green'></i></h4>");
                    }else{
                        span.html("<font color='red'>短信验证码错误</font>");
                    }
                }
            });
        });
        $('#captcha').click(function(){
            var src="{{url('home/member/captcha')}}?"+Math.random();
            $(this).attr('src',src);
        })
        $("[name='name']").blur(function(){
            var span=$(this).parent().parent().find('span');
            var str=$(this).val();
            var patt=/^\w{6,12}$/;
            if(patt.test(str)){
                span.html("<h4><i class='fa fa-check' style='color:green'></i></h4>");
            }else{
                span.html("<font color='red'>请输入6-12位字母数字下划线</font>");
            }
        })
        $("[name='passwd']").blur(function(){
            var span=$(this).parent().parent().find('span');
            var pwd=$(this).val();
            var pwdReg=/^\w{6,30}$/;
            var lower1=/^\d{6,}$/;//弱
            var lower2=/^\[A-Z]{6,}$/;//弱
            var lower3=/^\[a-z]{6,}$/;//弱
            var mid=/^\w{6,12}$/;//中
            if(!pwdReg.test(pwd)){
                span.html("<font color='red'>不符合规则</font>");
                return false;
            }else if(lower1.test(pwd)||lower2.test(pwd)||lower3.test(pwd)){
                span.html("<font color='#BCFD39'>弱</font>");
            }else if(mid.test(pwd)){
                span.html("<font color='#8CFF5F'>中</font>");
            }else{
                span.html("<font color='orange'>强</font>");
            }
        })
        $("[name='re-passwd']").blur(function(){
            var span=$(this).parent().parent().find('span');
            var pwd=$("[name='passwd']").val();
            var re_pwd=$(this).val();
            if(re_pwd==''){
                span.html("<font color='red'>不能为空</font>");
            }else if(re_pwd==pwd){
                span.html("<h4><i class='fa fa-check' style='color:green'></i></h4>");
            }else{
                span.html("<font color='red'>两次密码不一致</font>");
            }
        })
        $("[name='email']").blur(function(){
            var span=$(this).parent().parent().find('span');
            var str=$(this).val();
            var patt=/^\w{2,255}@[a-z0-9]{2,20}\.[a-z]{2,10}$/;
            if(patt.test(str)){
                span.html("<h4><i class='fa fa-check' style='color:green'></i></h4>");
            }else{
                span.html("<font color='red'>邮箱格式不正确</font>");
            }
        })
        $("[name='tel']").blur(function(){
            var span=$(this).parent().parent().find('span');
            var str=$(this).val();
            var patt=/^1(3|4|5|7|8)\d{9}$/;
            if(patt.test(str)){
                span.html("<h4><i class='fa fa-check' style='color:green'></i></h4>");
            }else{
                span.html("<font color='red'>手机号格式不正确</font>");
            }
        })
        $("[name='code']").blur(function(){
            var span=$(this).parent().parent().find('span');
            var code=$(this).val();
            var data={"code":code};
            $.post("{:U('captcha')}",data,function(msg){
                if(msg==1){
                    span.html("<h4><i class='fa fa-check' style='color:green'></i></h4>");
                }else{
                    span.html("<font color='red'>验证码错误</font>");
                }
            })
        })
        /*function checkForm(){
            var span='';
            $('input').focus();
            $('input').blur();
            for(var i=0;i<$('.regex').length;i++){
                if(i!=1){
                    span=$('.regex').eq(i).html();
                    if(span!='<h4><i class="fa fa-check" style="color:green"></i></h4>'){
                        return false;
                    }
                }
            }
        }*/
    </script>
@stop


