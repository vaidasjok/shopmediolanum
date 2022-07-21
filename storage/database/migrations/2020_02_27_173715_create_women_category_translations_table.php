<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWomenCategoryTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('women_category_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('women_category_id')->unsigned();
            $table->string('name');
            $table->text('description');

            $table->string('locale')->index();

            $table->unique(['women_category_id','locale']);
            $table->foreign('women_category_id')->references('id')->on('women_categories')->onDelete('cascade');
        });

        Schema::table('women_categories', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->dropColumn('description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('women_category_translations');
        Schema::table('women_categories', function (Blueprint $table) {
            $table->string('name');
            $table->text('description');
        });
    }
}
