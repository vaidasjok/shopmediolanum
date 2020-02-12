<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFrontendImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('frontend_images', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('type')->default(1);
            $table->string('image');
            $table->string('title');
            $table->string('link')->nullable();
            $table->tinyInteger('enabled')->default(1);
            
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
        Schema::dropIfExists('frontend_images');
    }
}
