<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransfersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('transfers', function(Blueprint $table) {
        $table->increments('id');
        $table->decimal('amount',20,2);
        $table->enum('type',['entrada','salida']);
        $table->date('date');
        $table->integer('status');
        $table->integer('balance_budgets_id')->unsigned()->index();
        $table->foreign('balance_budgets_id')->references('id')->on('balance_budgets')->onDelete('no action');
        $table->integer('spreadsheets_id')->unsigned()->index();
        $table->foreign('spreadsheets_id')->references('id')->on('spreadsheets')->onDelete('no action');
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
		Schema::drop('transfers');
	}

}
