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
        $settings = new Settings();
        $settings->url = 'http://localhost';
        $settings->email = 'john@doe.com';
        $settings->title = 'CMS';
        $settings->desc = 'CMS';
        $settings->keys = 'CMS';
        $settings->save();
    }
}
