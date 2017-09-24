<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('home/index');
});
Route::group(['prefix'=>'home','namespace'=>'Home'],function(){
    Route::get('index','IndexController@index');
    Route::get('cookie','IndexController@cookie');
    Route::group(['prefix'=>'member'],function(){
       Route::match(['get','post'],'register','MemberController@register');
       Route::post('login','MemberController@login');
       Route::get('logout','MemberController@logout');
       Route::get('captcha','MemberController@captcha');
       Route::get('info','MemberController@info');
       Route::match(['get','post'],'sendSms','MemberController@sendSms');
       Route::post('checkSms','MemberController@checkSms');
       Route::post('checkCaptcha','MemberController@checkCaptcha');
    });
    Route::match(['get','post'],'login','IndexController@login');
});
Route::group(['prefix'=>'admin','namespace'=>'Admin'],function(){
    Route::get('index','IndexController@index');
    Route::group(['prefix'=>'manager'],function(){
        Route::match(['get','post'],'login','ManagerController@login');
    });
});
