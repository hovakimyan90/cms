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
        $content_type = new ContentType();
        $content_type->type = "posts";
        $content_type->save();

        $content_type = new ContentType();
        $content_type->type = "static content";
        $content_type->save();

        $content_type = new ContentType();
        $content_type->type = "gallery";
        $content_type->save();
    }
}
