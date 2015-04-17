<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTypeBudgetsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('type_budgets', function(Blueprint $table) {
        $table->increments('id');
        $table->string('name');
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
        Schema::drop('type_budgets');
    }

}
