<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDistrictsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('districts', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->bigInteger('division_id')->unsigned();
			$table->string('geo_code', 10);
			$table->string('name', 100);
			$table->string('name_bn', 300);
			$table->bigInteger('created_by')->unsigned();
			$table->bigInteger('updated_by')->unsigned();
            $table->timestamps();
			$table->foreign('division_id')
      			  ->references('id')->on('divisions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('districts');
    }
}
