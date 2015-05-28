<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChecksTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
          Schema::create('checks', function(Blueprint $table) {
        $table->increments('id');
        $table->string('bill',100);
        $table->string('concept',100);
        $table->decimal('amount', 30, 2);
        $table->decimal('retention', 30, 2);
        $table->string('ckbill',20);
        $table->string('ckretention',20);
        $table->string('record',20);
        $table->date('date');
        $table->enum('simulation',['true','false']);
        $table->integer('voucher_id')->unsigned()->nullable()->index();
        $table->foreign('voucher_id')->references('id')->on('vouchers')->onDelete('no action');
        $table->integer('balance_budget_id')->unsigned()->index();
        $table->foreign('balance_budget_id')->references('id')->on('balance_budgets')->onDelete('no action');
        $table->integer('spreadsheet_id')->unsigned()->index();
        $table->foreign('spreadsheet_id')->references('id')->on('spreadsheets')->onDelete('no action');
        $table->integer('supplier_id')->unsigned()->index();
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
    public function down() {
        Schema::drop('checks');
    }

}
