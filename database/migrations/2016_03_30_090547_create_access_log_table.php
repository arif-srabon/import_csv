<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccessLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('access_log', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('office_id')->default(0)->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->string('login_ip', 100);
            $table->dateTime('login_datetime');
            $table->dateTime('logout_datetime')->nullable();
            $table->string('browser_info', 1500);
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
        Schema::drop('access_log');
    }
}
