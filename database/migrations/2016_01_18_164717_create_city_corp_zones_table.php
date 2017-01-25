<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCityCorpZonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('city_corp_zones', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->bigInteger('city_corp_paurasava_id')->nullable()->unsigned();
			$table->string('zone_name', 100);
			$table->string('zone_name_bn', 300)->nullable();
			$table->bigInteger('created_by')->nullable()->unsigned();
			$table->bigInteger('updated_by')->nullable()->unsigned();
            $table->timestamps();
			/*$table->foreign('city_corp_paurasava_id')
      			  ->references('id')->on('city_corp_paurasavas');*/
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('city_corp_zones');
    }
}
