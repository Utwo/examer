<?php

namespace App\Policies;

use App\Subject;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SubjectPolicy
{
    use HandlesAuthorization;

    /*
     * Check if User is authorized to view specific Subject
     */
    public function user_subscribed_subject(User $user, Subject $subject)
    {
        $subject_user = User::whereHas('StudentSubject', function ($query) use ($subject) {
            return $query->where('id', $subject->id)->where('active', 1);
        })->find($user->id);

        if ($subject_user == null) {
            return false;
        }
        return true;
    }
}
