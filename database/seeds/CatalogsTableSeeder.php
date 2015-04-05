<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use Illuminate\Database\Seeder;
/**
 * Description of CatalogsTableSeeder
 *
 * @author Anwar Sarmiento
 */
class CatalogsTableSeeder extends Seeder {
    //put your code here
    
      public function run() {
          \DB::table('catalogs')->insert([
            'id' => 1,
            'c' => '1',
            'sc' => '3',
            'g' => '2',
            'sg' => '3',
            'p' => '03',
            'sp' => '01',
            'r' => '0',
            'sr' => '0',
            'f' => '000',
            'name' => 'Intereses s/ cuentas corrientes y otros depositos en bancos estatales',
            'type' => 'ingresos',
            'groups_id' => 1,
            'token' => Crypt::encrypt('1-3-2-3-03-01-0-0-000')
         ]);
         \DB::table('catalogs')->insert([
            'id' => 2,
            'c' => '1',
            'sc' => '4',
            'g' => '1',
            'sg' => '1',
            'p' => '00',
            'sp' => '00',
            'r' => '0',
            'sr' => '0',
            'f' => '000',
            'name' => 'Tranferencias Corrientes del Gobierno Central',
            'type' => 'ingresos',
            'groups_id' => 1,
            'token' => Crypt::encrypt('1-4-1-1-00-00-0-0-000')
         ]);
          \DB::table('catalogs')->insert([
            'id' => 3,
            'c' => '3',
            'sc' => '3',
            'g' => '2',
            'sg' => '0',
            'p' => '00',
            'sp' => '00',
            'r' => '0',
            'sr' => '0',
            'f' => '000',
            'name' => 'Superavit Especifico',
            'type' => 'ingresos',
            'groups_id' => 2,
            'token' => Crypt::encrypt('3-3-2')
         ]);
           \DB::table('catalogs')->insert([
            'id' => 84,
            'c' => '1',
            'sc' => '3',
            'g' => '1',
            'sg' => '2',
            'p' => '04',
            'sp' => '01',
            'r' => '0',
            'sr' => '0',
            'f' => '000',
            'name' => 'Alquiler de Edificios e Instalaciones',
            'type' => 'ingresos',
            'groups_id' => 1,
            'token' => Crypt::encrypt('1-3-1-2-04-01-0-0-000')
         ]);
            \DB::table('catalogs')->insert([
            'id' => 85,
            'c' => '1',
            'sc' => '3',
            'g' => '1',
            'sg' => '2',
            'p' => '09',
            'sp' => '09',
            'r' => '0',
            'sr' => '0',
            'f' => '000',
            'name' => 'Venta de otros Servicios',
            'type' => 'ingresos',
            'groups_id' => 1,
            'token' => Crypt::encrypt('1-3-1-2-09-09-0-0-000')
         ]);
             \DB::table('catalogs')->insert([
            'id' => 86,
            'c' => '1',
            'sc' => '4',
            'g' => '2',
            'sg' => '0',
            'p' => '00',
            'sp' => '00',
            'r' => '0',
            'sr' => '0',
            'f' => '000',
            'name' => 'Transferencias Corrientes del Sector Privado',
            'type' => 'ingresos',
            'groups_id' => 1,
            'token' => Crypt::encrypt('1-4-2')
         ]); \DB::table('catalogs')->insert([
            'id' => 87,
            'c' => '1',
            'sc' => '4',
            'g' => '1',
            'sg' => '4',
            'p' => '00',
            'sp' => '00',
            'r' => '0',
            'sr' => '0',
            'f' => '000',
            'name' => 'Transferencias corrientes de gobierno locales',
            'type' => 'ingresos',
            'groups_id' => 1,
            'token' => Crypt::encrypt('1-4-1-4')
         ]);
          \DB::table('catalogs')->insert([
            'id' => 88,
            'c' => '',
            'sc' => '',
            'g' => '01',
            'sg' => '',
            'p' => '5',
            'sp' => '05',
            'r' => '',
            'sr' => '',
            'f' => '',
            'name' => 'Equipo y programas de computo',
            'type' => 'gastos',
            'groups_id' => 6,
            'token' => Crypt::encrypt('01-5-05')
         ]);
          \DB::table('catalogs')->insert([
            'id' => 89,
            'c' => '3',
            'sc' => '3',
            'g' => '2',
            'sg' => '0',
            'p' => '00',
            'sp' => '00',
            'r' => '0',
            'sr' => '0',
            'f' => '000',
            'name' => 'Superavit Especifico',
            'type' => 'ingresos',
            'groups_id' => 9,
            'token' => Crypt::encrypt('3-3-2')
         ]);
           \DB::table('catalogs')->insert([
            'id' => 90,
            'c' => '1',
            'sc' => '3',
            'g' => '1',
            'sg' => '1',
            'p' => '01',
            'sp' => '01',
            'r' => '0',
            'sr' => '0',
            'f' => '001',
            'name' => 'Ventas de Productos Agricolas CTP-MEP',
            'type' => 'ingresos',
            'groups_id' => 1,
            'token' => Crypt::encrypt('1-3-1-1-01-01-0-0-001')
         ]);
            \DB::table('catalogs')->insert([
            'id' => 91,
            'c' => '1',
            'sc' => '3',
            'g' => '1',
            'sg' => '1',
            'p' => '01',
            'sp' => '02',
            'r' => '0',
            'sr' => '0',
            'f' => '001',
            'name' => 'Ventas de semovientes-CTP-MEP',
            'type' => 'ingresos',
            'groups_id' => 1,
            'token' => Crypt::encrypt('1-3-1-1-01-02-0-0-001')
         ]);
          \DB::table('catalogs')->insert([
            'id' => 92,
            'c' => '1',
            'sc' => '3',
            'g' => '1',
            'sg' => '1',
            'p' => '09',
            'sp' => '03',
            'r' => '0',
            'sr' => '0',
            'f' => '001',
            'name' => 'Venta de reciclaje',
            'type' => 'ingresos',
            'groups_id' => 1,
            'token' => Crypt::encrypt('1-3-1-1-09-03-0-0-001')
         ]);
          
            \DB::table('catalogs')->insert([
            'id' => 93,
            'c' => '1',
            'sc' => '3',
            'g' => '1',
            'sg' => '2',
            'p' => '09',
            'sp' => '09',
            'r' => '4',
            'sr' => '0',
            'f' => '001',
            'name' => 'Ventas de servicios de CTP-MEP',
            'type' => '',
            'groups_id' => '',
            'token' => Crypt::encrypt('')
         ]);
             \DB::table('catalogs')->insert([
            'id' => 1,
            'c' => '',
            'sc' => '',
            'g' => '',
            'sg' => '',
            'p' => '',
            'sp' => '',
            'r' => '',
            'sr' => '',
            'f' => '',
            'name' => '',
            'type' => '',
            'groups_id' => '',
            'token' => Crypt::encrypt('')
         ]);
              \DB::table('catalogs')->insert([
            'id' => 1,
            'c' => '',
            'sc' => '',
            'g' => '',
            'sg' => '',
            'p' => '',
            'sp' => '',
            'r' => '',
            'sr' => '',
            'f' => '',
            'name' => '',
            'type' => '',
            'groups_id' => '',
            'token' => Crypt::encrypt('')
         ]);
              \DB::table('catalogs')->insert([
            'id' => 1,
            'c' => '',
            'sc' => '',
            'g' => '',
            'sg' => '',
            'p' => '',
            'sp' => '',
            'r' => '',
            'sr' => '',
            'f' => '',
            'name' => '',
            'type' => '',
            'groups_id' => '',
            'token' => Crypt::encrypt('')
         ]);
              \DB::table('catalogs')->insert([
            'id' => 1,
            'c' => '',
            'sc' => '',
            'g' => '',
            'sg' => '',
            'p' => '',
            'sp' => '',
            'r' => '',
            'sr' => '',
            'f' => '',
            'name' => '',
            'type' => '',
            'groups_id' => '',
            'token' => Crypt::encrypt('')
         ]);
              \DB::table('catalogs')->insert([
            'id' => 1,
            'c' => '',
            'sc' => '',
            'g' => '',
            'sg' => '',
            'p' => '',
            'sp' => '',
            'r' => '',
            'sr' => '',
            'f' => '',
            'name' => '',
            'type' => '',
            'groups_id' => '',
            'token' => Crypt::encrypt('')
         ]);
              \DB::table('catalogs')->insert([
            'id' => 1,
            'c' => '',
            'sc' => '',
            'g' => '',
            'sg' => '',
            'p' => '',
            'sp' => '',
            'r' => '',
            'sr' => '',
            'f' => '',
            'name' => '',
            'type' => '',
            'groups_id' => '',
            'token' => Crypt::encrypt('')
         ]);
              \DB::table('catalogs')->insert([
            'id' => 1,
            'c' => '',
            'sc' => '',
            'g' => '',
            'sg' => '',
            'p' => '',
            'sp' => '',
            'r' => '',
            'sr' => '',
            'f' => '',
            'name' => '',
            'type' => '',
            'groups_id' => '',
            'token' => Crypt::encrypt('')
         ]);
              \DB::table('catalogs')->insert([
            'id' => 1,
            'c' => '',
            'sc' => '',
            'g' => '',
            'sg' => '',
            'p' => '',
            'sp' => '',
            'r' => '',
            'sr' => '',
            'f' => '',
            'name' => '',
            'type' => '',
            'groups_id' => '',
            'token' => Crypt::encrypt('')
         ]);
              \DB::table('catalogs')->insert([
            'id' => 1,
            'c' => '',
            'sc' => '',
            'g' => '',
            'sg' => '',
            'p' => '',
            'sp' => '',
            'r' => '',
            'sr' => '',
            'f' => '',
            'name' => '',
            'type' => '',
            'groups_id' => '',
            'token' => Crypt::encrypt('')
         ]);
              \DB::table('catalogs')->insert([
            'id' => 1,
            'c' => '',
            'sc' => '',
            'g' => '',
            'sg' => '',
            'p' => '',
            'sp' => '',
            'r' => '',
            'sr' => '',
            'f' => '',
            'name' => '',
            'type' => '',
            'groups_id' => '',
            'token' => Crypt::encrypt('')
         ]);
              \DB::table('catalogs')->insert([
            'id' => 1,
            'c' => '',
            'sc' => '',
            'g' => '',
            'sg' => '',
            'p' => '',
            'sp' => '',
            'r' => '',
            'sr' => '',
            'f' => '',
            'name' => '',
            'type' => '',
            'groups_id' => '',
            'token' => Crypt::encrypt('')
         ]);
              \DB::table('catalogs')->insert([
            'id' => 1,
            'c' => '',
            'sc' => '',
            'g' => '',
            'sg' => '',
            'p' => '',
            'sp' => '',
            'r' => '',
            'sr' => '',
            'f' => '',
            'name' => '',
            'type' => '',
            'groups_id' => '',
            'token' => Crypt::encrypt('')
         ]);
              \DB::table('catalogs')->insert([
            'id' => 1,
            'c' => '',
            'sc' => '',
            'g' => '',
            'sg' => '',
            'p' => '',
            'sp' => '',
            'r' => '',
            'sr' => '',
            'f' => '',
            'name' => '',
            'type' => '',
            'groups_id' => '',
            'token' => Crypt::encrypt('')
         ]);
              \DB::table('catalogs')->insert([
            'id' => 1,
            'c' => '',
            'sc' => '',
            'g' => '',
            'sg' => '',
            'p' => '',
            'sp' => '',
            'r' => '',
            'sr' => '',
            'f' => '',
            'name' => '',
            'type' => '',
            'groups_id' => '',
            'token' => Crypt::encrypt('')
         ]);
              \DB::table('catalogs')->insert([
            'id' => 1,
            'c' => '',
            'sc' => '',
            'g' => '',
            'sg' => '',
            'p' => '',
            'sp' => '',
            'r' => '',
            'sr' => '',
            'f' => '',
            'name' => '',
            'type' => '',
            'groups_id' => '',
            'token' => Crypt::encrypt('')
         ]);
              \DB::table('catalogs')->insert([
            'id' => 1,
            'c' => '',
            'sc' => '',
            'g' => '',
            'sg' => '',
            'p' => '',
            'sp' => '',
            'r' => '',
            'sr' => '',
            'f' => '',
            'name' => '',
            'type' => '',
            'groups_id' => '',
            'token' => Crypt::encrypt('')
         ]);
              \DB::table('catalogs')->insert([
            'id' => 1,
            'c' => '',
            'sc' => '',
            'g' => '',
            'sg' => '',
            'p' => '',
            'sp' => '',
            'r' => '',
            'sr' => '',
            'f' => '',
            'name' => '',
            'type' => '',
            'groups_id' => '',
            'token' => Crypt::encrypt('')
         ]);
              \DB::table('catalogs')->insert([
            'id' => 1,
            'c' => '',
            'sc' => '',
            'g' => '',
            'sg' => '',
            'p' => '',
            'sp' => '',
            'r' => '',
            'sr' => '',
            'f' => '',
            'name' => '',
            'type' => '',
            'groups_id' => '',
            'token' => Crypt::encrypt('')
         ]);
              \DB::table('catalogs')->insert([
            'id' => 1,
            'c' => '',
            'sc' => '',
            'g' => '',
            'sg' => '',
            'p' => '',
            'sp' => '',
            'r' => '',
            'sr' => '',
            'f' => '',
            'name' => '',
            'type' => '',
            'groups_id' => '',
            'token' => Crypt::encrypt('')
         ]);
              \DB::table('catalogs')->insert([
            'id' => 1,
            'c' => '',
            'sc' => '',
            'g' => '',
            'sg' => '',
            'p' => '',
            'sp' => '',
            'r' => '',
            'sr' => '',
            'f' => '',
            'name' => '',
            'type' => '',
            'groups_id' => '',
            'token' => Crypt::encrypt('')
         ]);
              \DB::table('catalogs')->insert([
            'id' => 1,
            'c' => '',
            'sc' => '',
            'g' => '',
            'sg' => '',
            'p' => '',
            'sp' => '',
            'r' => '',
            'sr' => '',
            'f' => '',
            'name' => '',
            'type' => '',
            'groups_id' => '',
            'token' => Crypt::encrypt('')
         ]);
              \DB::table('catalogs')->insert([
            'id' => 1,
            'c' => '',
            'sc' => '',
            'g' => '',
            'sg' => '',
            'p' => '',
            'sp' => '',
            'r' => '',
            'sr' => '',
            'f' => '',
            'name' => '',
            'type' => '',
            'groups_id' => '',
            'token' => Crypt::encrypt('')
         ]);
              \DB::table('catalogs')->insert([
            'id' => 1,
            'c' => '',
            'sc' => '',
            'g' => '',
            'sg' => '',
            'p' => '',
            'sp' => '',
            'r' => '',
            'sr' => '',
            'f' => '',
            'name' => '',
            'type' => '',
            'groups_id' => '',
            'token' => Crypt::encrypt('')
         ]);
              \DB::table('catalogs')->insert([
            'id' => 1,
            'c' => '',
            'sc' => '',
            'g' => '',
            'sg' => '',
            'p' => '',
            'sp' => '',
            'r' => '',
            'sr' => '',
            'f' => '',
            'name' => '',
            'type' => '',
            'groups_id' => '',
            'token' => Crypt::encrypt('')
         ]);
              \DB::table('catalogs')->insert([
            'id' => 1,
            'c' => '',
            'sc' => '',
            'g' => '',
            'sg' => '',
            'p' => '',
            'sp' => '',
            'r' => '',
            'sr' => '',
            'f' => '',
            'name' => '',
            'type' => '',
            'groups_id' => '',
            'token' => Crypt::encrypt('')
         ]);
              \DB::table('catalogs')->insert([
            'id' => 1,
            'c' => '',
            'sc' => '',
            'g' => '',
            'sg' => '',
            'p' => '',
            'sp' => '',
            'r' => '',
            'sr' => '',
            'f' => '',
            'name' => '',
            'type' => '',
            'groups_id' => '',
            'token' => Crypt::encrypt('')
         ]);
              \DB::table('catalogs')->insert([
            'id' => 1,
            'c' => '',
            'sc' => '',
            'g' => '',
            'sg' => '',
            'p' => '',
            'sp' => '',
            'r' => '',
            'sr' => '',
            'f' => '',
            'name' => '',
            'type' => '',
            'groups_id' => '',
            'token' => Crypt::encrypt('')
         ]);
              \DB::table('catalogs')->insert([
            'id' => 1,
            'c' => '',
            'sc' => '',
            'g' => '',
            'sg' => '',
            'p' => '',
            'sp' => '',
            'r' => '',
            'sr' => '',
            'f' => '',
            'name' => '',
            'type' => '',
            'groups_id' => '',
            'token' => Crypt::encrypt('')
         ]);
              \DB::table('catalogs')->insert([
            'id' => 1,
            'c' => '',
            'sc' => '',
            'g' => '',
            'sg' => '',
            'p' => '',
            'sp' => '',
            'r' => '',
            'sr' => '',
            'f' => '',
            'name' => '',
            'type' => '',
            'groups_id' => '',
            'token' => Crypt::encrypt('')
         ]);
              \DB::table('catalogs')->insert([
            'id' => 1,
            'c' => '',
            'sc' => '',
            'g' => '',
            'sg' => '',
            'p' => '',
            'sp' => '',
            'r' => '',
            'sr' => '',
            'f' => '',
            'name' => '',
            'type' => '',
            'groups_id' => '',
            'token' => Crypt::encrypt('')
         ]);
              \DB::table('catalogs')->insert([
            'id' => 1,
            'c' => '',
            'sc' => '',
            'g' => '',
            'sg' => '',
            'p' => '',
            'sp' => '',
            'r' => '',
            'sr' => '',
            'f' => '',
            'name' => '',
            'type' => '',
            'groups_id' => '',
            'token' => Crypt::encrypt('')
         ]);
              \DB::table('catalogs')->insert([
            'id' => 1,
            'c' => '',
            'sc' => '',
            'g' => '',
            'sg' => '',
            'p' => '',
            'sp' => '',
            'r' => '',
            'sr' => '',
            'f' => '',
            'name' => '',
            'type' => '',
            'groups_id' => '',
            'token' => Crypt::encrypt('')
         ]);
              \DB::table('catalogs')->insert([
            'id' => 1,
            'c' => '',
            'sc' => '',
            'g' => '',
            'sg' => '',
            'p' => '',
            'sp' => '',
            'r' => '',
            'sr' => '',
            'f' => '',
            'name' => '',
            'type' => '',
            'groups_id' => '',
            'token' => Crypt::encrypt('')
         ]);
              \DB::table('catalogs')->insert([
            'id' => 1,
            'c' => '',
            'sc' => '',
            'g' => '',
            'sg' => '',
            'p' => '',
            'sp' => '',
            'r' => '',
            'sr' => '',
            'f' => '',
            'name' => '',
            'type' => '',
            'groups_id' => '',
            'token' => Crypt::encrypt('')
         ]);
              \DB::table('catalogs')->insert([
            'id' => 1,
            'c' => '',
            'sc' => '',
            'g' => '',
            'sg' => '',
            'p' => '',
            'sp' => '',
            'r' => '',
            'sr' => '',
            'f' => '',
            'name' => '',
            'type' => '',
            'groups_id' => '',
            'token' => Crypt::encrypt('')
         ]);
              \DB::table('catalogs')->insert([
            'id' => 1,
            'c' => '',
            'sc' => '',
            'g' => '',
            'sg' => '',
            'p' => '',
            'sp' => '',
            'r' => '',
            'sr' => '',
            'f' => '',
            'name' => '',
            'type' => '',
            'groups_id' => '',
            'token' => Crypt::encrypt('')
         ]);
              \DB::table('catalogs')->insert([
            'id' => 1,
            'c' => '',
            'sc' => '',
            'g' => '',
            'sg' => '',
            'p' => '',
            'sp' => '',
            'r' => '',
            'sr' => '',
            'f' => '',
            'name' => '',
            'type' => '',
            'groups_id' => '',
            'token' => Crypt::encrypt('')
         ]);
              \DB::table('catalogs')->insert([
            'id' => 1,
            'c' => '',
            'sc' => '',
            'g' => '',
            'sg' => '',
            'p' => '',
            'sp' => '',
            'r' => '',
            'sr' => '',
            'f' => '',
            'name' => '',
            'type' => '',
            'groups_id' => '',
            'token' => Crypt::encrypt('')
         ]);
              \DB::table('catalogs')->insert([
            'id' => 1,
            'c' => '',
            'sc' => '',
            'g' => '',
            'sg' => '',
            'p' => '',
            'sp' => '',
            'r' => '',
            'sr' => '',
            'f' => '',
            'name' => '',
            'type' => '',
            'groups_id' => '',
            'token' => Crypt::encrypt('')
         ]);
              \DB::table('catalogs')->insert([
            'id' => 1,
            'c' => '',
            'sc' => '',
            'g' => '',
            'sg' => '',
            'p' => '',
            'sp' => '',
            'r' => '',
            'sr' => '',
            'f' => '',
            'name' => '',
            'type' => '',
            'groups_id' => '',
            'token' => Crypt::encrypt('')
         ]);
              \DB::table('catalogs')->insert([
            'id' => 1,
            'c' => '',
            'sc' => '',
            'g' => '',
            'sg' => '',
            'p' => '',
            'sp' => '',
            'r' => '',
            'sr' => '',
            'f' => '',
            'name' => '',
            'type' => '',
            'groups_id' => '',
            'token' => Crypt::encrypt('')
         ]);
              \DB::table('catalogs')->insert([
            'id' => 1,
            'c' => '',
            'sc' => '',
            'g' => '',
            'sg' => '',
            'p' => '',
            'sp' => '',
            'r' => '',
            'sr' => '',
            'f' => '',
            'name' => '',
            'type' => '',
            'groups_id' => '',
            'token' => Crypt::encrypt('')
         ]);
              \DB::table('catalogs')->insert([
            'id' => 1,
            'c' => '',
            'sc' => '',
            'g' => '',
            'sg' => '',
            'p' => '',
            'sp' => '',
            'r' => '',
            'sr' => '',
            'f' => '',
            'name' => '',
            'type' => '',
            'groups_id' => '',
            'token' => Crypt::encrypt('')
         ]);
              \DB::table('catalogs')->insert([
            'id' => 1,
            'c' => '',
            'sc' => '',
            'g' => '',
            'sg' => '',
            'p' => '',
            'sp' => '',
            'r' => '',
            'sr' => '',
            'f' => '',
            'name' => '',
            'type' => '',
            'groups_id' => '',
            'token' => Crypt::encrypt('')
         ]);
              \DB::table('catalogs')->insert([
            'id' => 1,
            'c' => '',
            'sc' => '',
            'g' => '',
            'sg' => '',
            'p' => '',
            'sp' => '',
            'r' => '',
            'sr' => '',
            'f' => '',
            'name' => '',
            'type' => '',
            'groups_id' => '',
            'token' => Crypt::encrypt('')
         ]);
              \DB::table('catalogs')->insert([
            'id' => 1,
            'c' => '',
            'sc' => '',
            'g' => '',
            'sg' => '',
            'p' => '',
            'sp' => '',
            'r' => '',
            'sr' => '',
            'f' => '',
            'name' => '',
            'type' => '',
            'groups_id' => '',
            'token' => Crypt::encrypt('')
         ]);
              \DB::table('catalogs')->insert([
            'id' => 1,
            'c' => '',
            'sc' => '',
            'g' => '',
            'sg' => '',
            'p' => '',
            'sp' => '',
            'r' => '',
            'sr' => '',
            'f' => '',
            'name' => '',
            'type' => '',
            'groups_id' => '',
            'token' => Crypt::encrypt('')
         ]);
              \DB::table('catalogs')->insert([
            'id' => 1,
            'c' => '',
            'sc' => '',
            'g' => '',
            'sg' => '',
            'p' => '',
            'sp' => '',
            'r' => '',
            'sr' => '',
            'f' => '',
            'name' => '',
            'type' => '',
            'groups_id' => '',
            'token' => Crypt::encrypt('')
         ]);
              \DB::table('catalogs')->insert([
            'id' => 1,
            'c' => '',
            'sc' => '',
            'g' => '',
            'sg' => '',
            'p' => '',
            'sp' => '',
            'r' => '',
            'sr' => '',
            'f' => '',
            'name' => '',
            'type' => '',
            'groups_id' => '',
            'token' => Crypt::encrypt('')
         ]);
              \DB::table('catalogs')->insert([
            'id' => 1,
            'c' => '',
            'sc' => '',
            'g' => '',
            'sg' => '',
            'p' => '',
            'sp' => '',
            'r' => '',
            'sr' => '',
            'f' => '',
            'name' => '',
            'type' => '',
            'groups_id' => '',
            'token' => Crypt::encrypt('')
         ]);
              \DB::table('catalogs')->insert([
            'id' => 1,
            'c' => '',
            'sc' => '',
            'g' => '',
            'sg' => '',
            'p' => '',
            'sp' => '',
            'r' => '',
            'sr' => '',
            'f' => '',
            'name' => '',
            'type' => '',
            'groups_id' => '',
            'token' => Crypt::encrypt('')
         ]);
              \DB::table('catalogs')->insert([
            'id' => 1,
            'c' => '',
            'sc' => '',
            'g' => '',
            'sg' => '',
            'p' => '',
            'sp' => '',
            'r' => '',
            'sr' => '',
            'f' => '',
            'name' => '',
            'type' => '',
            'groups_id' => '',
            'token' => Crypt::encrypt('')
         ]);
              \DB::table('catalogs')->insert([
            'id' => 1,
            'c' => '',
            'sc' => '',
            'g' => '',
            'sg' => '',
            'p' => '',
            'sp' => '',
            'r' => '',
            'sr' => '',
            'f' => '',
            'name' => '',
            'type' => '',
            'groups_id' => '',
            'token' => Crypt::encrypt('')
         ]);
              \DB::table('catalogs')->insert([
            'id' => 1,
            'c' => '',
            'sc' => '',
            'g' => '',
            'sg' => '',
            'p' => '',
            'sp' => '',
            'r' => '',
            'sr' => '',
            'f' => '',
            'name' => '',
            'type' => '',
            'groups_id' => '',
            'token' => Crypt::encrypt('')
         ]);
              \DB::table('catalogs')->insert([
            'id' => 1,
            'c' => '',
            'sc' => '',
            'g' => '',
            'sg' => '',
            'p' => '',
            'sp' => '',
            'r' => '',
            'sr' => '',
            'f' => '',
            'name' => '',
            'type' => '',
            'groups_id' => '',
            'token' => Crypt::encrypt('')
         ]);
              \DB::table('catalogs')->insert([
            'id' => 1,
            'c' => '',
            'sc' => '',
            'g' => '',
            'sg' => '',
            'p' => '',
            'sp' => '',
            'r' => '',
            'sr' => '',
            'f' => '',
            'name' => '',
            'type' => '',
            'groups_id' => '',
            'token' => Crypt::encrypt('')
         ]);
              \DB::table('catalogs')->insert([
            'id' => 1,
            'c' => '',
            'sc' => '',
            'g' => '',
            'sg' => '',
            'p' => '',
            'sp' => '',
            'r' => '',
            'sr' => '',
            'f' => '',
            'name' => '',
            'type' => '',
            'groups_id' => '',
            'token' => Crypt::encrypt('')
         ]);
              \DB::table('catalogs')->insert([
            'id' => 1,
            'c' => '',
            'sc' => '',
            'g' => '',
            'sg' => '',
            'p' => '',
            'sp' => '',
            'r' => '',
            'sr' => '',
            'f' => '',
            'name' => '',
            'type' => '',
            'groups_id' => '',
            'token' => Crypt::encrypt('')
         ]);
              \DB::table('catalogs')->insert([
            'id' => 1,
            'c' => '',
            'sc' => '',
            'g' => '',
            'sg' => '',
            'p' => '',
            'sp' => '',
            'r' => '',
            'sr' => '',
            'f' => '',
            'name' => '',
            'type' => '',
            'groups_id' => '',
            'token' => Crypt::encrypt('')
         ]);
              \DB::table('catalogs')->insert([
            'id' => 1,
            'c' => '',
            'sc' => '',
            'g' => '',
            'sg' => '',
            'p' => '',
            'sp' => '',
            'r' => '',
            'sr' => '',
            'f' => '',
            'name' => '',
            'type' => '',
            'groups_id' => '',
            'token' => Crypt::encrypt('')
         ]);
              \DB::table('catalogs')->insert([
            'id' => 1,
            'c' => '',
            'sc' => '',
            'g' => '',
            'sg' => '',
            'p' => '',
            'sp' => '',
            'r' => '',
            'sr' => '',
            'f' => '',
            'name' => '',
            'type' => '',
            'groups_id' => '',
            'token' => Crypt::encrypt('')
         ]);
              \DB::table('catalogs')->insert([
            'id' => 1,
            'c' => '',
            'sc' => '',
            'g' => '',
            'sg' => '',
            'p' => '',
            'sp' => '',
            'r' => '',
            'sr' => '',
            'f' => '',
            'name' => '',
            'type' => '',
            'groups_id' => '',
            'token' => Crypt::encrypt('')
         ]);
              \DB::table('catalogs')->insert([
            'id' => 1,
            'c' => '',
            'sc' => '',
            'g' => '',
            'sg' => '',
            'p' => '',
            'sp' => '',
            'r' => '',
            'sr' => '',
            'f' => '',
            'name' => '',
            'type' => '',
            'groups_id' => '',
            'token' => Crypt::encrypt('')
         ]);
              \DB::table('catalogs')->insert([
            'id' => 1,
            'c' => '',
            'sc' => '',
            'g' => '',
            'sg' => '',
            'p' => '',
            'sp' => '',
            'r' => '',
            'sr' => '',
            'f' => '',
            'name' => '',
            'type' => '',
            'groups_id' => '',
            'token' => Crypt::encrypt('')
         ]);
              \DB::table('catalogs')->insert([
            'id' => 1,
            'c' => '',
            'sc' => '',
            'g' => '',
            'sg' => '',
            'p' => '',
            'sp' => '',
            'r' => '',
            'sr' => '',
            'f' => '',
            'name' => '',
            'type' => '',
            'groups_id' => '',
            'token' => Crypt::encrypt('')
         ]);
              \DB::table('catalogs')->insert([
            'id' => 1,
            'c' => '',
            'sc' => '',
            'g' => '',
            'sg' => '',
            'p' => '',
            'sp' => '',
            'r' => '',
            'sr' => '',
            'f' => '',
            'name' => '',
            'type' => '',
            'groups_id' => '',
            'token' => Crypt::encrypt('')
         ]);
              \DB::table('catalogs')->insert([
            'id' => 1,
            'c' => '',
            'sc' => '',
            'g' => '',
            'sg' => '',
            'p' => '',
            'sp' => '',
            'r' => '',
            'sr' => '',
            'f' => '',
            'name' => '',
            'type' => '',
            'groups_id' => '',
            'token' => Crypt::encrypt('')
         ]);
              \DB::table('catalogs')->insert([
            'id' => 1,
            'c' => '',
            'sc' => '',
            'g' => '',
            'sg' => '',
            'p' => '',
            'sp' => '',
            'r' => '',
            'sr' => '',
            'f' => '',
            'name' => '',
            'type' => '',
            'groups_id' => '',
            'token' => Crypt::encrypt('')
         ]);
              \DB::table('catalogs')->insert([
            'id' => 1,
            'c' => '',
            'sc' => '',
            'g' => '',
            'sg' => '',
            'p' => '',
            'sp' => '',
            'r' => '',
            'sr' => '',
            'f' => '',
            'name' => '',
            'type' => '',
            'groups_id' => '',
            'token' => Crypt::encrypt('')
         ]);
              \DB::table('catalogs')->insert([
            'id' => 1,
            'c' => '',
            'sc' => '',
            'g' => '',
            'sg' => '',
            'p' => '',
            'sp' => '',
            'r' => '',
            'sr' => '',
            'f' => '',
            'name' => '',
            'type' => '',
            'groups_id' => '',
            'token' => Crypt::encrypt('')
         ]);
              
             
          
      }
}
