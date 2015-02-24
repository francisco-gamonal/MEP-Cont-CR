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
        $table->integer('tasks_id')->unsigned()->index();
        $table->foreign('tasks_id')->references('id')->on('tasks')->onDelete('no action');
        $table->integer('menus_id')->unsigned()->index();
        $table->foreign('menus_id')->references('id')->on('menus')->onDelete('no action');
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
		Schema::drop('menu_user');
	}

}
