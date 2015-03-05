<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBalanceBudgetsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('balance_budgets', function(Blueprint $table) {
        $table->increments('id');
        $table->decimal('amount',20,2);
        $table->string('policies');
        $table->string('strategic');
        $table->string('operational');
        $table->string('goals');
        $table->integer('catalogs_id')->unsigned()->index();
        $table->foreign('catalogs_id')->references('id')->on('catalogs')->onDelete('no action');
        $table->integer('budgets_id')->unsigned()->index();
        $table->foreign('budgets_id')->references('id')->on('budgets')->onDelete('no action');
        $table->integer('types_budgets_id')->unsigned()->index();
        $table->foreign('types_budgets_id')->references('id')->on('types_budgets')->onDelete('no action');
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
	public function down()
	{
		Schema::drop('balance_budgets');
	}

}
