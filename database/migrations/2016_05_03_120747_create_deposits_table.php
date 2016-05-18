<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepositsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('deposits', function(Blueprint $table) {
			$table->increments('id');
			$table->string('number');
			$table->date('date');
            $table->decimal('amount',20,2);
            $table->string('depositor');
            $table->string('img_url');
            $table->string('token')->unique();
            $table->integer('bank_account_id')->unsigned()->index();
            $table->foreign('bank_account_id')->references('id')->on('bank_accounts')->onDelete('no action');
            $table->unique(['bank_account_id','date','number']);
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
		Schema::drop('deposits');
	}

}
