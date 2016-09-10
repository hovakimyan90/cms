<?php

use App\Models\ContentTypes;
use Illuminate\Database\Seeder;

class ContentTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ContentTypes::create([
            'type' => 'posts'
        ]);
        ContentTypes::create([
            'type' => 'static content'
        ]);
        ContentTypes::create([
            'type' => 'gallery'
        ]);
    }
}
