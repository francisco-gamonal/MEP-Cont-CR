<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuUserTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	Schema::create('menu_user', function(Blueprint $table) {
        $table->integer('task_id')->unsigned()->index();
        $table->foreign('task_id')->references('id')->on('tasks')->onDelete('no action');
        $table->integer('menu_id')->unsigned()->index();
        $table->foreign('menu_id')->references('id')->on('menus')->onDelete('no action');
        $table->integer('user_id')->unsigned()->index();
        $table->foreign('user_id')->references('id')->on('users')->onDelete('no action');
        $table->engine = 'InnoDB';
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('menu_user');
	}

}
