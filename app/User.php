<?php

namespace App;

use Guzzle\Tests\Service\Mock\Command\Sub\Sub;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'role'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['remember_token'];

    public function Project()
    {
        return $this->hasMany(Project::class);
    }

    public function Grade()
    {
        return $this->hasMany(Grade::class);
    }

    public function Subject()
    {
        return $this->hasMany(Subject::class);
    }

    public function StudentSubject()
    {
        return $this->belongsToMany(Subject::class)->withTimestamps();
    }

    public function getImageAttribute()
    {
        $client = new \GuzzleHttp\Client([
            'headers' => ['Authorization' => 'Bearer ' . $this->access_token]
        ]);
        $request = $client->request('GET', config('services.ubb.ubb_api') . config('services.ubb.ubb_api_version') . '/user/profile-img');
        $body = (string)$request->getBody();
        $header = $request->getHeader('Content-Type')[0];
        return 'data:' . $header . ';base64,' . base64_encode($body);
    }

    public function getMediaAttribute()
    {
        $sum = 0;
        $projects = $this->Project;
        if ($projects->count() < config('settings.max_project_upload')) {
            return null;
        }
        foreach ($projects as $project) {
            $media_proj = $project->Media;
            if (is_null($media_proj)) {
                return null;
            }
            $sum += $project->Media;
        }
        return round($sum / $projects->count(), 2);
    }
}
