<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksHasMenusTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	Schema::create('tasks_has_menus', function(Blueprint $table) {
        $table->integer('tasks_id')->unsigned()->index();
        $table->foreign('tasks_id')->references('id')->on('tasks')->onDelete('no action');
        $table->integer('menus_id')->unsigned()->index();
        $table->foreign('menus_id')->references('id')->on('menus')->onDelete('no action');
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
		Schema::drop('tasks_has_menus');
	}

}
