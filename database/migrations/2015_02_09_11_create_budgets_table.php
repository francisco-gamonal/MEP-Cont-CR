<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBudgetsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
         Schema::create('budgets', function(Blueprint $table) {
        $table->increments('id');
        $table->date('name');
        $table->string('source');
        $table->string('description');
        $table->string('year', 4);
        $table->integer('type');
        $table->string('global');
        $table->integer('status');
        $table->integer('schools_id')->unsigned()->index();
        $table->foreign('schools_id')->references('id')->on('schools')->onDelete('no action');
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
        Schema::drop('budgets');
    }

}
