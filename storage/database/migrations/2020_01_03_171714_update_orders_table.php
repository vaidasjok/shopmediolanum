<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('first_name');
            $table->string('address');
            $table->string('last_name');
            $table->string('phone');
            $table->string('zip');
            $table->string('email');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('first_name');
            $table->dropColumn('address');
            $table->dropColumn('last_name');
            $table->dropColumn('phone');
            $table->dropColumn('zip');
            $table->dropColumn('email');
        });
    }
}
