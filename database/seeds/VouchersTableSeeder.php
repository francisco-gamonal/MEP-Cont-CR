<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use Illuminate\Database\Seeder;
/**
 * Description of VouchersTableSeeder
 *
 * @author Anwar Sarmiento
 */
class VouchersTableSeeder extends Seeder {
    //put your code here
    
     public function run() {
        \DB::table('suppliers')->insert([
            'id' => 1,
            'imagen' => 'Stephanie Robles Ortega',
            'suppliers_id' => 1,
         ]);
    }
}
