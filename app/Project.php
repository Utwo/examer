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

    public function getMediaAttribute(){
        $sum = 0;
        $count = $this->Grade->count();
        foreach($this->Grade as $grade){
            $sum += $grade->grade;
        }
        if($count == 0){
            return null;
        }
        return $sum / $count;
    }
}
