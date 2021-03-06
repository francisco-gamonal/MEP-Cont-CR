<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        Model::unguard();

        $this->call('TypeUserTableSeeder');
        $this->call('SchoolsTableSeeder');
        $this->call('SuppliersTableSeeder');
        $this->call('UsersTableSeeder');
        $this->call('TasksTableSeeder');
        $this->call('MenuTableSeeder');
        $this->call('MenuTaskTableSeeder');
        $this->call('SchoolUserTableSeeder');
        $this->call('GroupsTableSeeder');
    }

}
