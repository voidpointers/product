<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateListingInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('listing_inventories', function (Blueprint $table) {
            $table->bigInteger('product_id')->unsigned()->default(0)->comment('库存ID');
            $table->string('sku', 120)->default('')->comment('SKU');
            $table->unique('product_id', 'uk_product_id');
            $table->tinyInteger('is_deleted')->unsigned()->default(0)->comment('是否删除');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('listing_inventories');
    }
}
