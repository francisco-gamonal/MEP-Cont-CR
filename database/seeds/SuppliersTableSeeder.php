<?php

use Illuminate\Database\Seeder;

class SuppliersTableSeeder extends Seeder {

    public function run() {
        \DB::table('suppliers')->insert([
            'id' => 1,
            'name' => 'Stephanie Robles Ortega',
            'charter' => '1-11320-776',
            'phone' => '27852529',
            'email' => 'roblesteph@hotmail.com'
        ]);
    }

}
