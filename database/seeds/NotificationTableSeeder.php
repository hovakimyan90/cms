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
        Notification::create([
            'from' => 1,
            'to' => 1,
            'type' => 1
        ]);
    }
}
