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
            $table->string('bill',100)->nullable();
            $table->string('concept',100)->nullable();
            $table->decimal('amount', 30, 2)->nullable();
            $table->decimal('retention', 30, 2)->nullable();
            $table->string('ckbill',20)->nullable();
            $table->string('ckretention',20)->nullable();
            $table->string('record',20)->nullable();
            $table->date('date')->nullable();
            $table->enum('simulation',['true','false']);
            $table->integer('voucher_id')->unsigned()->nullable()->index();
            $table->foreign('voucher_id')->references('id')->on('vouchers')->onDelete('no action');
            $table->integer('balance_budget_id')->unsigned()->nullable()->index();
            $table->foreign('balance_budget_id')->references('id')->on('balance_budgets')->onDelete('no action');
            $table->integer('spreadsheet_id')->unsigned()->nullable()->index();
            $table->foreign('spreadsheet_id')->references('id')->on('spreadsheets')->onDelete('no action');
            $table->integer('supplier_id')->unsigned()->nullable()->index();
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('no action');
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
        Schema::drop('temporary_checks');//
	}

}
