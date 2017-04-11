<?php

use Illuminate\Database\Seeder;

class ArchivesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {	
    	$attackers = array('./Port22', 'Mr. Landak', './Dayak',  './Ntx_404');
    	$teams = array('Security Exploded', 'Sanjungan Jiwa', 'Gantengers Crew', 'Priv Code');
        $country = array(
            'Indonesia',
            'Malaysia',
            'United States',
            'United Kingdom',
            'Israel',
            'Germany'
        );

        $country_code = array(
            'ID', 'MY', 'US', 'UK', 'IL', 'GR'
        );

        $os = array(
            'Linux',
            'Windows 2000',
            'RedHat'
        );
        $server = array(
            'Apache',
            'Nginx',
            'Litespeed'
        );

    	for ($i=0; $i < 2000 ; $i++) { 

    		$attacker = $attackers[array_rand($attackers)];
    		$team = $teams[array_rand($teams)];
    		$url = 'https://'.str_random(5).'.priv-code.io';
            $x = rand(0,5);
            $y = rand(0,2);
    		\App\Database\Archives::create([
                'id'            => NULL,
                'notifier'      => $attacker,
                'team'          => $team,
                'url'           => $url,
                'domain'        => parse_url($url)['host'],
                'ip'            => '192.168.43.50:'.$i,
                'geolocation'   => '{"country":"'.$country[$x].'","code":"'.$country_code[$x].'"}',
                'concept'       => (string)rand(1,7),
                'technology'    => '{"os":"'.$os[$y].'","server":"'.$server[$y].'"}',
                'content'       => 'Hacked by '.$attacker,
                'homeattack'    => (string)rand(0,1),
                'specialattack' => (string)rand(0,1),
                'massattack'    => (string)rand(0,1),
                'freshattack'   => (string)rand(0,1),
                'status'        => (string)rand(0,1),
                'datetime'      => \Carbon\Carbon::now()
    		]);
    	}
    }
}
