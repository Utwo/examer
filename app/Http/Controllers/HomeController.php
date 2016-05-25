<?php

namespace App\Http\Controllers;

use App\Subject;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function admin()
    {
        $subjects = Subject::where('user_id', auth()->user()->id)->where('active', 1)
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
