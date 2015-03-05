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
        $table->increments('id');
        $table->string('c',2);
        $table->string('sc',2);
        $table->string('g',2);
        $table->string('sg',2);
        $table->string('p',2);
        $table->string('sp',2);
        $table->string('r',2);
        $table->string('sr',2);
        $table->string('f',3);
        $table->string('name');
        $table->enum('type', ['ingresos', 'egresos']);
        $table->integer('groups_id')->unsigned()->index();
        $table->foreign('groups_id')->references('id')->on('groups')->onDelete('no action');
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
