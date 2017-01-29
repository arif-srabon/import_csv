<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegistrationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registration', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->integer('department_id', false, true);
            $table->string('client_id');
            $table->date('registration_date');

            // client information
            $table->string('client_name');
            $table->string('client_name_bn')->nullable();
            $table->string('mobile', 150);
            $table->string('email')->nullable();
            $table->date('date_of_birth');
            $table->integer('religion_id', false, true)->unsigned();
            $table->integer('gender_id', false, true)->unsigned();
            $table->integer('marital_status_id', false, true)->unsigned();
            $table->string('birth_certificate_no')->nullable();

            $table->string('father_name')->nullable();
            $table->string('father_phone')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('mother_phone')->nullable();
            $table->string('guardian_name')->nullable();
            $table->string('guardian_phone')->nullable();
            $table->enum('national_id_type', ['Client', 'Father', 'Mother', 'Husband', 'Guardian'])->nullable();
            $table->string('national_id')->nullable();
            $table->string('client_photo')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');

            // contact details
            $table->string('house_no', 150);
            $table->string('village', 150)->nullable();
            $table->bigInteger('division_id', false, true)->unsigned();
            $table->bigInteger('district_id', false, true)->unsigned();
            $table->bigInteger('upazilla_id', false, true)->unsigned();
            $table->bigInteger('ward', false, true)->nullable();

            $table->string('post_code', 60);
            $table->mediumText('present_address')->nullable();



//            // others information
//            $table->integer('education_qualification_id', false, true);
//            $table->string('education_qualification_others')->nullable();
//            $table->string('family_member')->nullable();
//            $table->string('earning_family_member')->nullable();
//
//            $table->integer('professional_id', false, true);
//            $table->string('professional_others')->nullable();
//            $table->integer('living_house_id', false, true);
//            $table->string('living_house_others')->nullable();

//            $table->integer('disability_type_id', false, true)->nullable();
//            $table->string('disability_type_others')->nullable();
//            $table->integer('family_monthly_income_id', false, true)->nullable();
//            $table->integer('referred_by_id', false, true)->nullable();
//            $table->string('referred_by_others')->nullable();
//
//            $table->enum('is_pwd_dss_registered', ['yes', 'no'])->default('no');
//            $table->string('pwd_dss_registered_no', 150)->nullable();
//            $table->date('pwd_dss_reg_issue_date')->nullable();
//            $table->mediumText('main_problem')->nullable();
//            $table->mediumText('expectation')->nullable();

            $table->bigInteger('created_by')->unsigned();
            $table->bigInteger('updated_by')->nullable();
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
        Schema::drop('registration');
    }
}
