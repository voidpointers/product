<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateListingProperties extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('listing_properties', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('listing_id')->unsigned()->default(0)->comment('产品ID');
            $table->string('item_weight_unit', 32)->comment('');
            $table->tinyInteger('item_weight')->unsigned()->default(0)->comment('重量');
            $table->tinyInteger('item_length')->unsigned()->default(0)->comment('长');
            $table->tinyInteger('item_width')->unsigned()->default(0)->comment('宽');
            $table->tinyInteger('item_height')->unsigned()->default(0)->comment('高');
            $table->json('materials')->comment('材料清单');
            $table->text('description')->comment('描述');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('listing_properties');
    }
}
