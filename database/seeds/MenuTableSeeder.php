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
            'name' => 'MENU',
            'url' => '/MENU'
         ]);
         \DB::table('menus')->insert([
            'id' => 2,
            'name' => 'USUARIOS',
            'url' => '/USUARIOS'
         ]);
           \DB::table('menus')->insert([
            'id' => 3,
            'name' => 'PRESUPUESTOS',
            'url' => '/PRESUPUESTOS'
         ]);
           \DB::table('menus')->insert([
            'id' => 4,
            'name' => 'TIPOS DE PRESUPUESTOS',
            'url' => '/TIPOS-DE-PRESUPUESTOS'
         ]);
           \DB::table('menus')->insert([
            'id' => 5,
            'name' => 'CATALOGOS',
            'url' => '/CATALOGOS'
         ]);
           \DB::table('menus')->insert([
            'id' => 6,
            'name' => 'GRUPOS DE CUENTAS',
            'url' => '/GRUPOS-DE-CUENTAS'
         ]);
    }
}
