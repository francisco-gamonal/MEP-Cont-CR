<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use Illuminate\Database\Seeder;
/**
 * Description of MenuTableSeeder
 *
 * @author Anwar Sarmiento
 */
class MenuTableSeeder extends Seeder {
    //put your code here
    
    public function run() {
         \DB::table('menus')->insert([
            'id' => 1,
            'name' => 'menu',
            'url' => '/menus'
         ]);
         \DB::table('menus')->insert([
            'id' => 2,
            'name' => 'usuarios',
            'url' => '/usuarios'
         ]);
    }
}
