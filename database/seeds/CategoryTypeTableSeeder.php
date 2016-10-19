<?php

use App\Models\CategoryType;
use Illuminate\Database\Seeder;

class CategoryTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category_type = new CategoryType();
        $category_type->type = "parent";
        $category_type->save();

        $category_type = new CategoryType();
        $category_type->type = "sub";
        $category_type->save();
    }
}
