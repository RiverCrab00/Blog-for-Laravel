<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member', function (Blueprint $table) {
            $table->increments('id');
            $table->string('mem_name',30)->notNull()->unique()->comment('用户名');
            $table->string('mem_pass',60)->notNull()->comment('密码');
            $table->enum('mem_sex',['男','女'])->notNull()->default('男')->comment('性别');
            $table->tinyInteger('mem_age')->notNull()->default(0)->comment('年龄');
            $table->string('mem_email',50)->notNull()->default('')->comment('邮箱');
            $table->char('mem_phone',11)->notNull()->default('')->comment('手机号');
            $table->string('mem_pic',50)->notNull()->default('')->comment('图片');
            $table->string('mem_desc',50)->notNull()->default('')->comment('介绍');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('member');
    }
}
