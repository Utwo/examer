<?php

use Illuminate\Database\Seeder;
use App\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create(['name' => 'User 1']);
        User::create(['name' => 'User 2']);
        User::create(['name' => 'User 3']);
    }
}
