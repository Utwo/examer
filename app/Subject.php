<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = ['name', 'semester', 'active', 'user_id'];

    public function User()
    {
        return $this->belongsTo(User::class);
    }

    public function StudentUser()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function Project()
    {
        return $this->hasMany(Project::class);
    }
}
