<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cookie;

class IndexController extends Controller
{
    function index(){
        return view('home.index');
    }
    function cookie(){
        Cookie::queue('test', 'hello, world', 10);
        echo Cookie::get('test');
    }
}
