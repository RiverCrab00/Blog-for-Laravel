<?php

namespace App\Home;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticable;

class Member extends Authenticable
{
    protected $table='member';
    protected $primaryKey='id';
    protected $fillable=['mem_name','password','mem_phone','mem_sex','mem_age','mem_desc','mem_pic'];
    //会修改create_at字段和update_at字段
    //public $timestamps=false;
}
