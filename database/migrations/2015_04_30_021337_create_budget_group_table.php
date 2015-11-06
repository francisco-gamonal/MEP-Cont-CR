<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBudgetGroupTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	 	Schema::create('budget_group', function(Blueprint $table) {
            $table->integer('budget_id')->unsigned()->index();
            $table->foreign('budget_id')->references('id')->on('budgets')->onDelete('no action');
            $table->integer('group_id')->unsigned()->index();
            $table->foreign('group_id')->references('id')->on('groups')->onDelete('no action');
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
		Schema::drop('budget_group');
	}

}
