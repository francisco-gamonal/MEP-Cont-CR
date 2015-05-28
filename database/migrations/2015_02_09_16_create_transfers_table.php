<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
class CreateTransfersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('transfers', function(Blueprint $table) {
            $table->increments('code');
            $table->decimal('amount', 30, 2);
            $table->enum('type', ['entrada', 'salida']);
            $table->date('date');
            $table->enum('simulation',['true','false']);
            $table->integer('balance_budget_id')->unsigned()->index();
            $table->foreign('balance_budget_id')->references('id')->on('balance_budgets')->onDelete('no action');
            $table->integer('spreadsheet_id')->unsigned()->index();
            $table->foreign('spreadsheet_id')->references('id')->on('spreadsheets')->onDelete('no action');
            $table->string('token')->unique();
            $table->engine = 'InnoDB';
            $table->timestamps();
            $table->softDeletes();
        });
        DB::unprepared('ALTER TABLE `transfers` DROP PRIMARY KEY, ADD PRIMARY KEY (  `code` ,  `balance_budget_id` )');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('transfers');
    }

}
