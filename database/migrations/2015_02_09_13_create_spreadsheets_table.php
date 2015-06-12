<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpreadsheetsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('spreadsheets', function(Blueprint $table) {
            $table->increments('id');
            $table->string('number',5);
            $table->string('year', 4);
            $table->date('date');
            $table->enum('simulation',['true','false']);
            $table->integer('type_budget_id')->unsigned()->index();
            $table->foreign('type_budget_id')->references('id')->on('type_budgets')->onDelete('no action');
            $table->integer('budget_id')->unsigned()->index();
            $table->foreign('budget_id')->references('id')->on('budgets')->onDelete('no action');
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
        Schema::drop('spreadsheets');
    }

}
