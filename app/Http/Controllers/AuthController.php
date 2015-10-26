<?php

namespace App\Http\Controllers;

use App\Project;
use App\User;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Auth;
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
        Auth::login($user);
        return redirect()->intended('/profile');

    }

    public function show()
    {
        $user = Auth::user()->load(['Project' => function ($query) {
            return $query->with('Grade');
        }]);

        $projects = Project::where('user_id', '<>', Auth::id())->with('Grade')->get();
        return view('profile')->withUser($user)->withProjects($projects);
    }
}
