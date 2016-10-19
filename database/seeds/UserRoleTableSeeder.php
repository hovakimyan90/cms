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
        $user_role = new UserRole();
        $user_role->role = 'User';
        $user_role->save();

        $user_role = new UserRole();
        $user_role->role = 'Admin';
        $user_role->save();
    }
}
