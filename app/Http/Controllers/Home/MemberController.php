<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;
use Illuminate\Support\Facades\Session;
use Flc\Dysms\Client;
use Flc\Dysms\Request\SendSms;

class MemberController extends Controller
{
    function register(Request $request){
        if($request->isMethod('post')){

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
        Session::set('captcha',$captcha); //存储验证码
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
}
