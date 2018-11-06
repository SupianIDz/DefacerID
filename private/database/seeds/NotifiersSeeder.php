<?php

use Illuminate\Database\Seeder;

class NotifiersSeeder extends Seeder
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
        foreach ($attackers as $key => $value) {
            $x = rand(500, 1000);
            \App\Database\Notifiers::create([
                'id'        => null,
                'notifier'  => $value,
                'team'      => $teams[$key],
                'home'      => (string)1000-$x,
                'special'   => (string)1000-$x,
                'published' => (string)1000-$x,
                'total'     => $x,
            ]);
        }
    }
}
