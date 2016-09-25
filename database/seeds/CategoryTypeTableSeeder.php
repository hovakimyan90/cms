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
        CategoryType::create([
            'type' => 'parent'
        ]);
        CategoryType::create([
            'type' => 'sub'
        ]);
    }
}
