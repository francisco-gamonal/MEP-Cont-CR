<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBudgetTypeBudgetTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('budget_type_budget', function(Blueprint $table) {
            $table->integer('budget_id')->unsigned()->index();
            $table->foreign('budget_id')->references('id')->on('budgets')->onDelete('no action');
            $table->integer('type_budget_id')->unsigned()->index();
            $table->foreign('type_budget_id')->references('id')->on('type_budgets')->onDelete('no action');
            $table->engine = 'InnoDB';
       });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('budget_type_budget');
    }

}
