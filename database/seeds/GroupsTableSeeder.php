<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use Illuminate\Database\Seeder;
/**
 * Description of GroupsTableSeeder
 *
 * @author Anwar Sarmiento
 */
class GroupsTableSeeder extends Seeder {
    //put your code here
    
     public function run() {
          \DB::table('groups')->insert([
            'id' => 1,
            'code' => '1',
            'name' => 'INGRESOS CORRIENTES',
            'type' => 'ingresos',
            'token' => Crypt::encrypt('INGRESOS CORRIENTES')
         ]);
          \DB::table('groups')->insert([
            'id' => 2,
            'code' => '2',
            'name' => 'INGRESOS DE CAPITAL',
            'type' => 'ingresos',
            'token' => Crypt::encrypt('INGRESOS DE CAPITAL')
         ]);
          \DB::table('groups')->insert([
            'id' => 3,
            'code' => '0',
            'name' => 'REMUNERACIONES',
            'type' => 'egresos',
            'token' => Crypt::encrypt('REMUNERACIONES')
         ]);
          \DB::table('groups')->insert([
            'id' => 4,
            'code' => '1',
            'name' => 'SERVICIOS',
            'type' => 'egresos',
            'token' => Crypt::encrypt('SERVICIOS')
         ]);
          \DB::table('groups')->insert([
            'id' => 5,
            'code' => '2',
            'name' => 'MATERIALES Y SUMINISTROS',
            'type' => 'egresos',
            'token' => Crypt::encrypt('MATERIALES Y SUMINISTROS')
         ]);
          \DB::table('groups')->insert([
            'id' => 6,
            'code' => '5',
            'name' => 'BIENES DURADEROS',
            'type' => 'egresos',
            'token' => Crypt::encrypt('BIENES DURADEROS')
         ]);
          \DB::table('groups')->insert([
            'id' => 7,
            'code' => '6',
            'name' => 'TRANSFERENCIAS CORRIENTES',
            'type' => 'egresos',
            'token' => Crypt::encrypt('TRANSFERENCIAS CORRIENTES')
         ]);
          \DB::table('groups')->insert([
            'id' => 8,
            'code' => '7',
            'name' => 'SUMINISTROS',
            'type' => 'egresos',
            'token' => Crypt::encrypt('SUMINISTROS')
         ]);
          \DB::table('groups')->insert([
            'id' => 9,
            'code' => '3',
            'name' => 'FINANCIAMIENTO',
            'type' => 'egresos',
            'token' => Crypt::encrypt('FINANCIAMIENTO')
         ]);
       
    }
}
