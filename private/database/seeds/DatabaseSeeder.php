<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tables = array(
            'Settings',
            'Concepts',
            /*'Notifiers',
            'Teams',
            'Archives'*/
            );
        foreach ($tables as $table) {
            $this->call($table.'Seeder');
        }
    }
}
