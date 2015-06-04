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
            'url' => '/MENU',
            'icon_font' => 'fa fa-bars'
         ]);
         \DB::table('menus')->insert([
            'id' => 2,
            'name' => 'USUARIOS',
            'url' => '/USUARIOS',
            'icon_font' => 'fa fa-users'
         ]);
           \DB::table('menus')->insert([
            'id' => 3,
            'name' => 'PRESUPUESTOS',
            'url' => '/PRESUPUESTOS',
            'icon_font' => 'fa fa-list-alt'
         ]);
           \DB::table('menus')->insert([
            'id' => 4,
            'name' => 'TIPOS DE PRESUPUESTOS',
            'url' => '/TIPOS-DE-PRESUPUESTOS',
            'icon_font' => 'glyphicon glyphicon-th-large'
         ]);
           \DB::table('menus')->insert([
            'id' => 5,
            'name' => 'CATALOGOS',
            'url' => '/CATALOGOS',
            'icon_font' => 'fa fa-barcode'
         ]);
           \DB::table('menus')->insert([
            'id' => 6,
            'name' => 'GRUPOS DE CUENTAS',
            'url' => '/GRUPOS-DE-CUENTAS',
            'icon_font' => 'fa fa-files-o'
         ]);
    }
}
