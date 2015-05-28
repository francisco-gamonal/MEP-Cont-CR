<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use Illuminate\Database\Seeder;
/**
 * Description of MenusTasksTableSeeder
 *
 * @author Anwar Sarmiento
 */
class MenuTaskTableSeeder {
    //put your code here
    public function run() {
        \DB::table('menu_task')->insert([
            'task_id' => 1,
            'menu_id' => 2
         ]);
        \DB::table('menu_task')->insert([
             'task_id' => 2,
            'menu_id' => 2
         ]);
    }
}
