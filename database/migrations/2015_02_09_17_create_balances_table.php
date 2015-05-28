<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBalancesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('balances', function(Blueprint $table) {
            $table->increments('id');
            $table->enum('type', ['entrada', 'salida']);
            $table->decimal('amount', 30, 2);
            $table->enum('simulation', ['true', 'false']);
            $table->integer('balance_budget_id')->unsigned()->nullable()->index();
            $table->foreign('balance_budget_id')->references('id')->on('balance_budgets')->onDelete('no action');
            $table->integer('check_id')->unsigned()->nullable()->index();
            $table->foreign('check_id')->references('id')->on('checks')->onDelete('no action');
            $table->integer('transfer_code')->unsigned()->nullable()->index();
            $table->foreign('transfer_code')->references('id')->on('transfers')->onDelete('no action');
            $table->integer('transfer_balance_budget_id')->unsigned()->nullable()->index();
            $table->foreign('transfer_balance_budget_id')->references('id')->on('transfers')->onDelete('no action');
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
        Schema::drop('balances');
    }

}
