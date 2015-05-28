<?php

use Illuminate\Database\Seeder;

class SchoolsTableSeeder extends Seeder {

    public function run() {
        \DB::table('schools')->insert([
            'id' => 1,
            'name' => 'COLEGIO TECNICO PROFESIONAL DE QUEPOS',
            'charter' => '3-008-056720',
            'circuit' => '01',
            'code' => '5748',
            'ffinancing' => 'LEY 6746 FONDO GENERAL PARA JUNTAS DE EDUCACIÓN Y ADMINISTRATIVAS',
            'titleone' => 'MINISTERIO DE EDUCACIÓN PÚBLICA',
            'titletwo' => 'DIRECCIÓN REGIONAL DE EDUCACIÓN DE AGUIRRE'
        ]);
    }

}
