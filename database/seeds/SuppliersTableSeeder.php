<?php

use Illuminate\Database\Seeder;

class SuppliersTableSeeder extends Seeder {

    public function run() {
        \DB::table('suppliers')->insert([
            'id' => 1,
            'charter' => '1-11320-776',
            'name' => 'Stephanie Robles Ortega',
            'phone' => '27852529',
            'email' => 'roblesteph@hotmail.com',
            'token' => sha1(md5(uniqid('1-11320-776',true)))
        ]);
    }

}
