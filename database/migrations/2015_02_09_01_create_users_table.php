<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('users', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('last');
            $table->string('email')->unique();
            $table->string('password');
            $table->integer('type_users_id')->unsigned()->index();
            $table->foreign('type_users_id')->references('id')->on('type_users')->onDelete('no action');
            $table->integer('suppliers_id')->unsigned()->nullable()->index();
            $table->foreign('suppliers_id')->references('id')->on('suppliers')->onDelete('no action');
            $table->rememberToken();
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
        Schema::drop('users');
    }

}
