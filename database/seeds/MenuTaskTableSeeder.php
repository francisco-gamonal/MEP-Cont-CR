<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use Illuminate\Database\Seeder;
/**
 * Description of MenuTaskTableSeeder
 *
 * @author Anwar Sarmiento
 */
class MenuTaskTableSeeder extends Seeder {
    //put your code here
    
    public function run() {
         \DB::table('menu_task')->insert([
            'task_id' => 1,
            'menu_id' => 2,
            'status' => 1
         ]);
         \DB::table('menu_task')->insert([
            'task_id' => 2,
            'menu_id' => 2,
            'status' => 1
         ]);
    }
}
