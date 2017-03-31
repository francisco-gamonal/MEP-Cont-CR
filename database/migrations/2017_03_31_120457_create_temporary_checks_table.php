<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTemporaryChecksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('temporary_checks', function(Blueprint $table) {
            $table->increments('id');
            $table->string('number');
            $table->date('date');
            $table->decimal('amount',20,2);
            $table->string('depositor');
            $table->string('img_url');
            $table->string('token')->unique();
            $table->integer('_id')->unsigned()->index();
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
        Schema::drop('temporary_checks');//
	}

}
