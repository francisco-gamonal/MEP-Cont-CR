<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
         Schema::create('groups', function(Blueprint $table) {
        $table->increments('id');
        $table->string('code',10);
        $table->string('name',80);
        $table->enum('type',['ingresos','egresos']);
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
        Schema::drop('groups');
    }

}
