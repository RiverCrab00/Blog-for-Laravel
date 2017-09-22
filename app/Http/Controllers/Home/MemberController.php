<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;
use Flc\Dysms\Client;
use Flc\Dysms\Request\SendSms;
use App\Home\Member;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class MemberController extends Controller
{
    function register(Request $request){
        if($request->isMethod('post')){
            //获取表单数据
            $data=$request->only(['mem_name','mem_pass','mem_phone']);
            $rules=[
                'mem_name'=>'required|unique:member,mem_name',
                'mem_pass'=>['required','regex:/^\w{6,30}$/'],
                'mem_phone'=>['required','regex:/^1[34578][0-9]{9}$/'],
            ];
            $msgs=[
                'mem_name.required'=>'用户名不能为空',
                'mem_name.unique'=>'用户名已存在',
                'mem_pass.required'=>'密码不能为空',
                'mem_pass.regex'=>'密码非法',
                'mem_phone.required'=>'手机号不能为空',
                'mem_phone.regex'=>'手机号不规范',
            ];
            //验证
            $validator=Validator::make($data,$rules,$msgs);
            var_dump($validator->errors()->messages());
            die;
            if($validator->passes()){
                $data['mem_pass']=bcrypt($data['mem_pass']);
                $res=Member::create($data);
                if($res){
                    redirect('home/index')->with('msg','注册成功');
                }else{
                    redirect('home/member/register')->with('msg','注册成功');
                }
            }else{
                return redirect('home/member/register')
                ->withErrors($validator)
                ->withInput();
            }
        }else{
            return view('home.register');
        }
    }
    function captcha(){
        $mem=new \Memcache();
        $mem->connect('127.0.0.1','11211');
        $phraseBuilder=new PhraseBuilder(4);
        $builder = new CaptchaBuilder(null,$phraseBuilder);
        $builder->build();
        $captcha=$builder->getPhrase();
        $mem->set('captcha',$captcha,0,3000);
        //\Session::set('captcha',$captcha); //存储验证码
        return response($builder->output())
            ->header('Content-type','image/jpeg');
    }
    function checkCaptcha(Request $request){
        $code=$request->input('code');
        $mem=new \Memcache();
        $mem->connect('127.0.0.1','11211');
        $captcha=$mem->get('captcha');
        if($code==$captcha){
            return 1;
        }else{
            return 0;
        }
    }
    function checkSms(Request $request){
        $code=$request->input('code');
        $sms_code=\Cookie::get('sms_code');
        if($code==$sms_code&&$code!=''){
            return ['info'=>true];
        }else{
            return ['info'=>false];
        }
    }
    function sendSms(Request $request){
        $phone=$request->input('phone');
        $config = [
            'accessKeyId'    => 'LTAIh7A6op2uz4Mj',
            'accessKeySecret' => 'AZMp0elpzbwFaPHUftAVbzwPbpT7so',
        ];
        $client  = new Client($config);
        $sendSms = new SendSms;
        $sendSms->setPhoneNumbers($phone);
        $sendSms->setSignName('张梁个人网站');
        $sendSms->setTemplateCode('SMS_91845074');
        $code=rand(100000, 999999);
        $sendSms->setTemplateParam(['code' => $code]);
        //$sendSms->setOutId('demo');
        \Cookie::queue('sms_code',$code, 3);
        $res=$client->execute($sendSms);
        if($res){
            return ['info'=>true];
        }else{
            return ['info'=>false];
        }
    }
    function login(Request $request){
        $name=$request->input('name');
        $pass=$request->input('pass');
        $code=$request->input('code');
        $data=array(
          'name'=>$name,
          'pass'=>$pass,
          'code'=>$code,
        );
        $rules=[
            'name'=>'required',
            'pass'=>['required','regex:/^\w{6,30}$/'],
            'code'=>'required|captcha',
        ];
        $msgs=[
            'name.required'=>'用户名不能为空',
            'pass.required'=>'密码不能为空',
            'pass.regex'=>'用户名或密码错误',
            'code.required'=>'验证码不能为空',
            'code.captcha'=>'验证码错误'
        ];
        $validator=Validator::make($data,$rules,$msgs);
        if($validator->passes()){
            $res=Auth::guard('home')->attempt(['mem_name'=>$name,'mem_pass'=>$pass]);
            if($res){
                return 1;
            }else{
                return '用户名或密码错误';
            }
        }else{
            $str='';
            $errors=$validator->errors()->messages();
            foreach($errors as $error){
                $str.=$error[0]."<br />";
            }
            return $str;
        }
    }
}
