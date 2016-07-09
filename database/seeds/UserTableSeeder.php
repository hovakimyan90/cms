<?php

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'username' => 'admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('123456'),
            'role_id' => 1,
            'approve' => 1,
            'verify' => 1
        ]);
        User::create([
            'username' => 'test@test.com',
            'email' => 'test@test.com',
            'password' => Hash::make('123456'),
            'role_id' => 2,
            'approve' => 1,
            'verify' => 1
        ]);
    }
}
