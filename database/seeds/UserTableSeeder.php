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
        $user = new User();
        $user->first_name = 'Super';
        $user->last_name = 'Admin';
        $user->username = 'admin';
        $user->email = 'admin@admin.com';
        $user->password = Hash::make('123456');
        $user->role_id = 1;
        $user->approve = 1;
        $user->save();

        $user = new User();
        $user->first_name = 'Test';
        $user->last_name = 'User';
        $user->username = 'test@test.com';
        $user->email = 'test@test.com';
        $user->password = Hash::make('123456');
        $user->role_id = 2;
        $user->approve = 1;
        $user->save();
    }
}
