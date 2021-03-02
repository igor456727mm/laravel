<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Subscription extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscribe', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('subscribe_id');
            $table->foreign('subscribe_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropForeign('subscribe_user_id_foreign');
        Schema::dropIndex('subscribe_user_id_index');
        Schema::dropColumn('user_id');
        Schema::dropForeign('subscribe_subscribe_id_foreign');
        Schema::dropIndex('subscribe_subscribe_id_index');
        Schema::dropColumn('subscribe_id');
        Schema::dropIfExists('subscribe');
    }
}
