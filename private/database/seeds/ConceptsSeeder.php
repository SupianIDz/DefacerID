<?php

use Illuminate\Database\Seeder;

class ConceptsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $concepts = array(
        	'Admin Poor Password',
        	'Brute Force',
        	'DNS Hijacking',
        	'File Inclusion',
        	'SQL Injection',
        	'Social Engineering',
        	'Others'
        );
        foreach ($concepts as $value) {
        	\App\Database\Concepts::create([
				'id'    => NULL,
				'title' => $value
        	]);
        }
    }
}
