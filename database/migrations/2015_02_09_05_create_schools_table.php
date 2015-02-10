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
        $table->string('name');
        $table->string('charter');
        $table->string('circuit');
        $table->string('code');
        $table->string('ffinancing');
        $table->string('president');
        $table->string('secretary');
        $table->string('account');
        $table->string('title_1');
        $table->string('title_2');
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
