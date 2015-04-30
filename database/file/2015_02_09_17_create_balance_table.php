<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBalanceTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('balance', function(Blueprint $table) {
        $table->increments('id');
        $table->enum('type',['entrada','salida']);
        $table->decimal('amount',20,2);
        $table->integer('status');
        $table->integer('balance_budgets_id')->unsigned()->nullable()->index();
        $table->foreign('balance_budgets_id')->references('id')->on('balance_budgets')->onDelete('no action');
        $table->integer('checks_id')->unsigned()->nullable()->index();
        $table->foreign('checks_id')->references('id')->on('checks')->onDelete('no action');
        $table->integer('transfers_id')->unsigned()->nullable()->index();
        $table->foreign('transfers_id')->references('id')->on('transfers')->onDelete('no action');
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
            Schema::drop('balance');
    }

}
