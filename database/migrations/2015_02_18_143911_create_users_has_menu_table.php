<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersHasMenuTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	Schema::create('users_has_menu', function(Blueprint $table) {
        $table->integer('tasks_id')->unsigned()->index();
        $table->foreign('tasks_id')->references('id')->on('tasks')->onDelete('no action');
        $table->integer('menu_id')->unsigned()->index();
        $table->foreign('menu_id')->references('id')->on('menu')->onDelete('no action');
        $table->integer('users_id')->unsigned()->index();
        $table->foreign('users_id')->references('id')->on('users')->onDelete('no action');
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
	public function down()
	{
		Schema::drop('users_has_menu');
	}

}
