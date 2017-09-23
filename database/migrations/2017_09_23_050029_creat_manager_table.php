<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatManagerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manager', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username',20)->unique()->notNull()->comment('管理员姓名');
            $table->string('password',60)->notNull()->comment('密码');
            $table->char('phone',11)->notNull()->defalut('')->comment('手机号');
            $table->string('email',30)->notNull()->default('')->comment('邮箱');
            $table->tinyInteger('role_id')->notNull()->default(0)->comment('所属角色');
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
        Schema::dropIfExists('manager');
    }
}
