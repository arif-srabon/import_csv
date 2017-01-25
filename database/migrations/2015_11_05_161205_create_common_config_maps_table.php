<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommonConfigMapsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('common_config_maps', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->string('display_name', 200);
			$table->string('display_name_bn', 300);
			$table->string('table_name', 200);
			$table->Integer('weight');
			$table->tinyInteger('is_active')->default(0);
			$table->bigInteger('created_by')->nullable()->unsigned();
			$table->bigInteger('updated_by')->nullable()->unsigned();
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
        Schema::drop('common_config_maps');
    }
}
