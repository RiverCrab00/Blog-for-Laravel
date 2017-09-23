<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
class ManagerController extends Controller
{
    function login(Request $request){
        if($request->getMethod()=='POST'){
            $res=Auth::guard('admin')->attempt($request->only('username','password'),1);
            var_dump($res);
        }else{
            return view('admin.login');
        }
    }
}
