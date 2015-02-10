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
        $table->string('bill');
        $table->string('concept');
        $table->decimal('amount', 20, 2);
        $table->decimal('retention', 20, 2);
        $table->string('ckfactura');
        $table->string('ckretention');
        $table->string('record');
        $table->date('date');
        $table->integer('status');
        $table->integer('vouchers_id')->unsigned()->nullable()->index();
        $table->foreign('vouchers_id')->references('id')->on('vouchers')->onDelete('no action');
        $table->integer('balance_budgets_id')->unsigned()->index();
        $table->foreign('balance_budgets_id')->references('id')->on('balance_budgets')->onDelete('no action');
        $table->integer('spreadsheets_id')->unsigned()->index();
        $table->foreign('spreadsheets_id')->references('id')->on('spreadsheets')->onDelete('no action');
        $table->integer('suppliers_id')->unsigned()->index();
        $table->foreign('suppliers_id')->references('id')->on('suppliers')->onDelete('no action');
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
