<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateListingImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('listing_images', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('listing_id')->unsigned()->default(0)->comment('产品ID');
            $table->bigInteger('image_id')->unsigned()->default(0)->comment('图片ID');
            $table->string('image')->default('')->comment('产品图片');
            $table->unique('listing_id', 'uk_listing_id');
            $table->index('image_id', 'idx_image_id');
        });

        DB::statement("ALTER TABLE `listing_images` comment '图片表'"); // 表注释
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('listing_images');
    }
}
