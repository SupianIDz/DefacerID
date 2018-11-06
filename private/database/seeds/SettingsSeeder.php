<?php

use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Database\Settings::create([
            'title'       => 'Priv Code',
            'subtitle'    => 'Private Web Service',
            'description' => 'Unrestricted Information',
            'keywords'    => 'Unrestricted Information'
        ]);
    }
}
