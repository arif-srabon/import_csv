<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('email');
            $table->string('password');

            $table->string('full_name')->nullable();
            $table->integer('designation_id', false, true)->nullable();
            $table->string('official_email')->nullable();
            $table->string('present_address', 1000)->nullable();
            $table->string('permanent_address', 1000)->nullable();


            $table->integer('division_id', false, true)->nullable();
            $table->integer('district_id', false, true)->nullable();
            $table->integer('location_type_id', false, true)->nullable();
            $table->integer('thana_upazila_id', false, true)->nullable();
            $table->integer('city_corp_paurasava_id', false, true)->nullable();

            $table->string('user_photo')->nullable();
            $table->string('mobile', 150)->nullable();
            $table->string('national_id', 150)->nullable();
            $table->string('office_phone', 60)->nullable();
            $table->string('home_phone', 60)->nullable();
            $table->tinyInteger('status', false, true);

            $table->mediumText('permissions')->nullable();
            $table->timestamp('last_login')->nullable();

            $table->bigInteger('created_by')->nullable()->unsigned();
            $table->bigInteger('updated_by')->nullable()->unsigned();
            $table->timestamps();

            // We'll need to ensure that MySQL uses the InnoDB engine to
            // support the indexes, other engines aren't affected.
            $table->engine = 'InnoDB';
            $table->unique('email');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
