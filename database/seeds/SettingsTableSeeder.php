<?php

use App\Models\Settings;
use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Settings::create([
            'url' => 'http://localhost',
            'email' => 'john@doe.com',
            'title' => 'CMS',
            'desc' => 'CMS',
            'keys' => 'CMS'
        ]);
    }
}
