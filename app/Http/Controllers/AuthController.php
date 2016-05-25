<?php

namespace App\Http\Controllers;

use App\Project;
use App\Subject;
use App\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
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
            if (!@ftp_login($conn_id, $username, $pass)) {
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

    public function admin()
    {
        $subjects = Subject::where('user_id', auth()->user()->id)
            ->where('active', 1)
            ->with(['StudentUser' => function ($query) {
                return $query->where('role', 'student')->with('Project.Grade');
            }])->get();
        return view('admin.admin')->withSubjects($subjects);
    }

    public function show(Request $request)
    {
        $user = auth()->user()->load(['StudentSubject' => function ($query) {
            return $query->where('active', 1);
        }]);
        $filter_subject = $request->has('subject') ? $request->subject : $user->StudentSubject->first()->name;

        $subject = Subject::where('name', $filter_subject)->whereHas('StudentUser', function ($query) {
            return $query->where('id', auth()->user()->id);
        })->with(['Project' => function ($query) {
            return $query->with('Grade');
        }])->first();

        $my_projects = $subject->Project->where('user_id', auth()->user()->id);
        $other_projects = $subject->Project->diff($my_projects);
        $given_grades = $other_projects->pluck('Grade')->collapse()->where('user_id', auth()->user()->id);
        $warning_string = $this->make_warning_string($given_grades->count(), $my_projects->count());

        return view('student.profile')
            ->withUser($user)
            ->withSubject($subject)
            ->withMyProjects($my_projects)
            ->withOtherProjects($other_projects)
            ->withGivenGrades($given_grades)
            ->withWarningMessage($warning_string);
    }

    public function redirectToProvider()
    {
        return Socialite::with('ubb')->scopes(['basic_user_read'])->redirect();
    }

    public function handleProviderCallback()
    {
        $user = Socialite::with('ubb')->user();
        $role = array_search('teacher', array_column($user->user['role'], 'name')) === false ? 'student' : 'teacher';
        $auth_user = User::firstOrCreate([
            'email' => $user->user['email'],
            'name' => $user->user['name'],
            'role' => $role
        ]);
        $auth_user->access_token = $user->token['access_token'];
        $auth_user->refresh_token = $user->token['refresh_token'];
        $auth_user->save();
        auth()->login($auth_user);

        $client = new \GuzzleHttp\Client(['headers' => ['Authorization' => 'Bearer ' . $auth_user->access_token]]);
        $body = $client->request('GET', 'http://licenta-back.dev/api/v1/user/subject')->getBody();
        $subjects = json_decode($body);
        if ($role == 'teacher') {
            foreach ($subjects->subject as $subject) {
                Subject::firstOrCreate([
                    'name' => $subject->name,
                    'semester' => $subject->semester_id,
                    'user_id' => $auth_user->id
                ]);
            }
            return redirect()->route('admin');
        } else {
            $subject_local = Subject::whereIn('name', array_column($subjects->subject, 'name'))->get(['id']);
            $ids = $subject_local->pluck('id');
            $auth_user->StudentSubject()->sync($ids->toArray());
            return redirect()->route('profile');
        }
    }

    private function make_warning_string($grade_count, $project_count)
    {
        $string = 'You need to add ';
        $remaining_project = config('settings.max_project_upload') - $project_count;
        $remaining_grade = config('settings.max_grade_add') - $grade_count;
        $string .= $remaining_grade > 0 ? $this->format_string('grade', $remaining_grade) . ' and ' : $string;
        $string .= $remaining_project > 0 ? $this->format_string('project', $remaining_project) : $string;
        if (str_word_count($string) > 4) {
            return $string;
        }
        return null;
    }

    private function format_string($txt, $remaining)
    {
        return $remaining . ' more ' . (($remaining == 1) ? $txt : str_plural($txt));
    }

    public function show_login()
    {
        return view('login');
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('show_login');
    }
}
