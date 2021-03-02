<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UserAction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_action', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('action')->nullable(false);
            $table->string('action_model')->nullable(false);
            $table->integer('action_id')->nullable(false);
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
        Schema::dropForeign('user_action_user_id_foreign');
        Schema::dropIndex('user_action_user_id_index');
        Schema::dropColumn('user_id');
        Schema::dropIfExists('user_action');
    }
}
