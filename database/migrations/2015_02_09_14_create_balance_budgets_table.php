<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBalanceBudgetsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('balance_budgets', function(Blueprint $table) {
            $table->increments('id');
            $table->decimal('amount', 30, 2);
            $table->string('policies');
            $table->string('strategic');
            $table->string('operational');
            $table->string('goals');
            $table->integer('catalog_id')->unsigned()->index();
            $table->foreign('catalog_id')->references('id')->on('catalogs')->onDelete('no action');
            $table->integer('budget_id')->unsigned()->index();
            $table->foreign('budget_id')->references('id')->on('budgets')->onDelete('no action');
            $table->integer('type_budget_id')->unsigned()->index();
            $table->foreign('type_budget_id')->references('id')->on('type_budgets')->onDelete('no action');
            $table->enum('simulation', ['true', 'false']);
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
        Schema::drop('balance_budgets');
    }

}
