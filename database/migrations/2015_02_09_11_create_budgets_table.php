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
            $table->date('name',80);
            $table->string('source',150);
            $table->string('description', 200);
            $table->string('year', 4);
            $table->enum('type', ['ordinario', 'extraordinario']);
            $table->string('global', 1);
            $table->integer('school_id')->unsigned()->index();
            $table->foreign('school_id')->references('id')->on('schools')->onDelete('no action');
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
        Schema::drop('budgets');
    }

}
