<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVouchersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('vouchers', function(Blueprint $table) {
            $table->increments('id');
            $table->string('imagen');
            $table->integer('suppliers_id')->unsigned()->index();
            $table->foreign('suppliers_id')->references('id')->on('suppliers')->onDelete('no action');
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
        Schema::drop('vouchers');
    }

}
