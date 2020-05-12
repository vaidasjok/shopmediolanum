<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_translations', function (Blueprint $table) {
            $table->Increments('id');
            $table->bigInteger('product_id')->unsigned();
            $table->string('name', 100);
            $table->text('description');

            $table->string('locale')->index();

            $table->unique(['product_id','locale']);
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });

        Schema::table('products', function (Blueprint $table) {
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
        Schema::dropIfExists('product_translations');
        Schema::table('products', function (Blueprint $table) {
            $table->string('name');
            $table->text('description');
        });
    }
}
