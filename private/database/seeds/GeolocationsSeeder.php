<?php

use Illuminate\Database\Seeder;

class GeolocationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $locations = array(
            'ID'	=> 'Indonesia',
            'MY'	=> 'Malaysia',
            'US'	=> 'United States',
            'UK'	=> 'United Kingdom',
            'IL'	=> 'Israel',
              'GR'	=> 'Germany'
        );

        foreach ($locations as $code => $country) {
            \App\Database\Geolocations::create([
                'id'   => null,
                'name' => $country,
                'code' => $code
            ]);
        }
    }
}
