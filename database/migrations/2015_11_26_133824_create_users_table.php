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
            $table->string('full_name_bn')->nullable();
            $table->integer('designation_id', false, true)->nullable();
            $table->integer('department_id', false, true)->nullable();
            $table->string('official_email')->nullable();
            $table->string('office_phone', 60)->nullable();

            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('mobile', 150)->nullable();
            $table->string('national_id', 150)->nullable();
            $table->string('home_phone', 60)->nullable();
            $table->integer('gender_id', false, true)->nullable()->unsigned();
            $table->integer('marital_status_id', false, true)->nullable()->unsigned();
            $table->string('blood_group', 30)->nullable();
            $table->date('date_of_birth')->nullable();
            $table->date('date_of_joining')->nullable();

            $table->string('user_photo')->nullable();
            $table->string('user_sign')->nullable();

            $table->string('permanent_house_road')->nullable();
            $table->string('permanent_village')->nullable();
            $table->integer('permanent_division', false, true)->nullable();
            $table->integer('permanent_district', false, true)->nullable();
            $table->integer('permanent_upzilla', false, true)->nullable();
            $table->integer('permanent_ward', false, true)->nullable();
            $table->string('permanent_postcode', 30)->nullable();

            $table->string('present_house_road')->nullable();
            $table->string('present_village')->nullable();
            $table->integer('present_division', false, true)->nullable();
            $table->integer('present_district', false, true)->nullable();
            $table->integer('present_upzilla', false, true)->nullable();
            $table->integer('present_ward', false, true)->nullable();
            $table->string('present_postcode', 30)->nullable();

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
