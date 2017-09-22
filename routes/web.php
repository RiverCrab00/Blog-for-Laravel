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
       Route::get('captcha','MemberController@captcha');
       Route::match(['get','post'],'sendSms','MemberController@sendSms');
       Route::post('checkSms','MemberController@checkSms');
       Route::post('checkCaptcha','MemberController@checkCaptcha');
    });
});
