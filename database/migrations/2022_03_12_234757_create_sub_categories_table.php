<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('category_id');
            $table->unsignedInteger('parent_id')->default(0);
            $table->char('translation_lang', 10);
            $table->unsignedInteger('translation_of');
            $table->char('name',150);
            $table->char('slug',150)->nullable(true);
            $table->char('photo',150)->nullable(true);
            $table->tinyInteger('active') ->default(1); //active=1
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('main_categories');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sub_categories');
    }
}
