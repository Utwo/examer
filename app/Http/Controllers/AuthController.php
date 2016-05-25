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
        $body = $client->request('GET', config('services.ubb.ubb_api') . config('services.ubb.ubb_api_version') . '/user/subject')->getBody();
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
            $ids = Subject::whereIn('name', array_column($subjects->subject, 'name'))->get(['id'])->pluck('id');
            $auth_user->StudentSubject()->sync($ids->toArray());
            return redirect()->intended(route('profile'));
        }
    }
}
