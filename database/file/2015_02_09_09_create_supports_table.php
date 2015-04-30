<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSupportsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('supports', function(Blueprint $table) {
        $table->increments('id');
        $table->string('title');
        $table->mediumText('message');
        $table->integer('users_id')->unsigned()->index();
        $table->foreign('users_id')->references('id')->on('users')->onDelete('no action');
        $table->string('token')->unique();
        $table->engine = 'InnoDB';
        $table->timestamps();
        $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('supports');
    }

}
