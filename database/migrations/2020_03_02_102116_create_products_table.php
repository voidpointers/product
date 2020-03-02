<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('listings', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('listing_id')->unsigned()->default(0)->comment('Etsy产品ID');
            $table->bigInteger('shop_id')->unsigned()->default(0)->comment('店铺ID');
            $table->bigInteger('user_id')->unsigned()->default(0)->comment('店铺用户ID');
            $table->bigInteger('category_id')->unsigned()->default(0)->comment('分类ID');
            $table->string('title')->default('')->comment('标题');
            $table->decimal('price')->unsigned()->default(0)->comment('单价');
            $table->mediumInteger('quantity')->unsigned()->default(0)->comment('数量');
            $table->string('sku')->default('')->comment('SKU');
            $table->json('tags')->comment('标签，json数组');
            $table->string('url')->default('')->comment('URL');
            $table->mediumInteger('views')->comment('浏览量');
            $table->mediumInteger('num_favorers')->comment('喜欢数量');
            $table->tinyInteger('state')->unsigned()->comment(0)->comment('状态');
            $table->integer('creation_tsz')->unsigned()->default(0)->comment('Etsy创建时间');
            $table->integer('ending_tsz')->unsigned()->default(0)->comment('Etsy截止时间');
            $table->integer('last_modified_tsz')->unsigned()->default(0)->comment('最近更新时间');
            $table->integer('create_time')->unsigned()->default(0)->comment('创建时间');
            $table->integer('update_time')->unsigned()->default(0)->comment('更新时间');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
