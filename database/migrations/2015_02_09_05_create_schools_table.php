<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchoolsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('schools', function(Blueprint $table) {
        $table->increments('id');
        $table->string('name',150);
        $table->string('charter',60);
        $table->string('circuit',20);
        $table->string('code',20);
        $table->string('ffinancing',150);
        $table->string('president',150);
        $table->string('secretary',150);
        $table->string('account',150);
        $table->string('titleOne',200);
        $table->string('titleTwo',200);
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
        Schema::drop('schools');
    }

}
