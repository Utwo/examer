<?php

namespace App\Http\Controllers;

use App\Project;
use App\User;
use Illuminate\Http\Request;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller {
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    public function authenticate(Request $request)
    {
        $ftp_server = "scs.ubbcluj.ro";
        $username = $request->name;
        $pass = $request->password;

        $this->validate($request, [
            'name' => 'required|max:255',
            'password' => 'required|min:4|max:255',
        ]);

        // try to login
        if (app()->environment() == 'production') {
            $conn_id = ftp_connect($ftp_server) or die("Couldn't connect to server.");
            if (! @ftp_login($conn_id, $username, $pass)) {
                return redirect()->back()->withInput()->withErrors("Invalid username or password");
            }
            ftp_close($conn_id);
        } else if (app()->environment() == 'local' && User::where('name', $username)->count() != 1) {
            return redirect()->back()->withInput()->withErrors("Invalid username or password");
        }

        $user = User::firstOrCreate(['name' => $username]);
        auth()->login($user);
        return redirect()->intended(route('profile'));

    }

    public function show()
    {
        $user = auth()->user()->load(['Project' => function ($query) {
            return $query->with('Grade');
        }])->load('Grade');
        $projects = Project::where('user_id', '<>', auth()->user()->id)->with('Grade')->get();
        $warning_string = $this->make_warning_string($user->Grade->count(), $user->Project->count());
        return view('profile')->withUser($user)->withProjects($projects)->withWarningMessage($warning_string);
    }

    private function make_warning_string($grade_count, $project_count)
    {
        $string = 'You need to add ';
        $ok = 0;
        $remaining_project = config('settings.max_project_upload') - $project_count;
        $remaining_grade = config('settings.max_grade_add') - $grade_count;
        if ($remaining_grade > 0) {
            $union = ' and ';
            $ok = 1;
            $grade_txt = 'grades';
            if ($remaining_grade == 1) {
                $grade_txt = 'grade';
            }
            if($remaining_project == 0){
                $union = '.';
            }
            $string .= $remaining_grade . ' more ' . $grade_txt . $union;
        }
        if ($remaining_project > 0) {
            $ok = 1;
            $project_txt = 'projects';
            if ($remaining_project == 1) {
                $project_txt = 'project';
            }
            $string .= $remaining_project . ' more ' . $project_txt . '.';
        }
        if ($ok) {
            return $string;
        }
        return null;
    }
}
