<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    function index(){
        return view('home.index');
    }
    function cookie(){
        Cookie::queue('test', 'hello, world', 10);
        echo Cookie::get('test');
    }
    function login(Request $request){
        if($request->isMethod('post')){
            $res=Auth::guard('home')->attempt($request->only('mem_name','password'),1);
            var_dump($res);
        }else{
            return view('home.login');
        }
    }
}
