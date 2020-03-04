<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->integer('category_id')->unsigned()->default(0)->comment('分类ID');
            $table->integer('parent_id')->unsigned()->default(0)->comment('父类ID');
            $table->string('name')->default('')->comment('分类名');
            $table->string('meta_title')->default('')->comment('meta标题');
            $table->text('meta_keywords')->default('')->comment('meta关键字');
            $table->string('meta_description')->default('')->comment('meta描述');
            $table->string('page_description')->default('')->comment('页面描述');
            $table->string('page_title')->default('')->comment('页面标题');
            $table->string('category_name')->default('')->comment('分类名');
            $table->string('short_name')->default('')->comment('短名');
            $table->string('long_name')->default('')->comment('长名');
            $table->integer('num_children')->unsigned()->default(0)->comment('子分类数量');
            $table->unique('category_id', 'uk_category_id');
        });

        DB::statement("ALTER TABLE `categories` comment '分类表'"); // 表注释
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
