<?php

use Illuminate\Database\Seeder;

class TeamsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $teams = array('Security Exploded', 'Sanjungan Jiwa', 'Gantengers Crew', 'Priv Code');
        foreach ($teams as $key => $value) {
        	$x = rand(500,1000);
        	\App\Database\Teams::create([
				'id'        => NULL,
				'team'  => $value,
				'home'      => (string)1000-$x,
				'special'   => (string)1000-$x,
				'published' => (string)1000-$x,
				'total'     => $x,
        	]);
        }
    }
}
