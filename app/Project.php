<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model {
    protected $fillable = ['name', 'extension', 'user_id'];

    public function User()
    {
        return $this->belongsTo(User::class);
    }

    public function Grade()
    {
        return $this->hasMany(Grade::class);
    }
}
