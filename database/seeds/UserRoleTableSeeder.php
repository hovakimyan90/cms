<?php

use App\Models\UserRole;
use Illuminate\Database\Seeder;

class UserRoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserRole::create([
            'role' => 'User'
        ]);
        UserRole::create([
            'role' => 'Admin'
        ]);
    }
}
