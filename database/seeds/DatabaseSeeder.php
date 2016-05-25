<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Project;
use App\Subject;
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

        //DB::table('users')->delete();
        //DB::table('projects')->delete();
        //DB::table('grades')->delete();

        $this->call(UserTableSeeder::class);

        factory(User::class, 5)->create();
        factory(Subject::class, 5)->create();
        factory(Project::class, 10)->create();
        //factory(Grade::class, 20)->create();

        $users = \App\User::get(['id']);
        foreach($users as $user){
            $user->StudentSubject()->attach(Subject::get(['id'])->random(3)->pluck(['id'])->toArray());
        }

        Model::reguard();
    }
}
