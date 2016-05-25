<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model {
    protected $fillable = ['name', 'extension', 'user_id', 'subject_id'];

    public function User()
    {
        return $this->belongsTo(User::class);
    }

    public function Subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function Grade()
    {
        return $this->hasMany(Grade::class);
    }

    public function getMediaAttribute(){
        $count = $this->Grade->count();
        if($count < config('settings.grade_for_project')){
            return null;
        }
        $sum = $this->Grade->sum('grade');
        return round($sum / $count, 2);
    }
}
