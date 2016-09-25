<?php

use App\Models\ContentType;
use Illuminate\Database\Seeder;

class ContentTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ContentType::create([
            'type' => 'posts'
        ]);
        ContentType::create([
            'type' => 'static content'
        ]);
        ContentType::create([
            'type' => 'gallery'
        ]);
    }
}
