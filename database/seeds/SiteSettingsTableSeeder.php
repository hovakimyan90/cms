<?php

use App\Models\SiteSettings;
use Illuminate\Database\Seeder;

class SiteSettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SiteSettings::create([
            'url' => 'http://localhost',
            'email' => 'john@doe.com',
            'title' => 'CMS',
            'desc' => 'CMS',
            'keys' => 'CMS'
        ]);
    }
}
