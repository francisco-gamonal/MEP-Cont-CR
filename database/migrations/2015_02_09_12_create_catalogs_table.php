<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCatalogsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('catalogs', function(Blueprint $table) {
            $table->increments('id')->nullable();
            $table->string('c', 2)->nullable();
            $table->string('sc', 2)->nullable();
            $table->string('g', 2)->nullable();
            $table->string('sg', 2)->nullable();
            $table->string('p', 2)->nullable();
            $table->string('sp', 2)->nullable();
            $table->string('r', 2)->nullable();
            $table->string('sr', 2)->nullable();
            $table->string('f', 3)->nullable();
            $table->string('name');
            $table->enum('type', ['ingresos', 'egresos']);
            $table->integer('group_id')->unsigned()->index();
            $table->foreign('group_id')->references('id')->on('groups')->onDelete('no action');
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
        Schema::drop('catalogs');
    }

}
