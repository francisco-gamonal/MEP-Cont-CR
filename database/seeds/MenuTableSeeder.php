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
            'route' => 'MENU',
            'name' => 'MENU',
            'url' => '/MENU'
         ]);
         \DB::table('menus')->insert([
            'id' => 2,
            'route' => 'USUARIOS',
            'name' => 'USUARIOS',
            'url' => '/USUARIOS'
         ]);
           \DB::table('menus')->insert([
            'id' => 3,
            'route' => 'PRESUPUESTOS',
            'name' => 'PRESUPUESTOS',
            'url' => '/PRESUPUESTOS'
         ]);
           \DB::table('menus')->insert([
            'id' => 4,
            'route' => 'TIPO-DE-PRESUPUESTOS',
            'name' => 'TIPO DE PRESUPUESTOS',
            'url' => '/TIPO-DE-PRESUPUESTOS'
         ]);
           \DB::table('menus')->insert([
            'id' => 5,
            'route' => 'CATALOGOS',
            'name' => 'CATALOGOS',
            'url' => '/CATALOGOS'
         ]);
           \DB::table('menus')->insert([
            'id' => 6,
            'route' => 'GRUPOS-DE-CUENTAS',
            'name' => 'GRUPOS DE CUENTAS',
            'url' => '/GRUPOS-DE-CUENTAS'
         ]);
    }
}
