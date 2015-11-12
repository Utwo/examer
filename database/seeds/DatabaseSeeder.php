<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Project;
use App\Grade;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        DB::table('users')->delete();
        DB::table('projects')->delete();
        DB::table('grades')->delete();

        $this->call(UserTableSeeder::class);

        factory(User::class, 5)->create();
        factory(Project::class, 10)->create();
        factory(Grade::class, 20)->create();

        Model::reguard();
    }
}
