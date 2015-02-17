<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use Illuminate\Database\Seeder;
/**
 * Description of SchoolsHasUsersTableSeeder
 *
 * @author Anwar Sarmiento
 */
class SchoolsHasUsersTableSeeder extends Seeder{
    //put your code here
     public function run() {
        \DB::table('schools_has_users')->insert([
            'users_id' => 1,
            'schools_id' => 1
         ]);
        \DB::table('schools_has_users')->insert([
             'users_id' => 2,
            'schools_id' => 1
         ]);
    }
}
