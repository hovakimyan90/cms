<?php

use App\Models\Notification;
use Illuminate\Database\Seeder;

class NotificationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $notification = new Notification();
        $notification->from = 1;
        $notification->to = 1;
        $notification->type = 1;
        $notification->save();
    }
}
