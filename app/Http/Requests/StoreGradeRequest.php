<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Project;
use App\Subject;
use Illuminate\Support\Facades\Gate;

class StoreGradeRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $project = Project::with('Grade')->findOrFail($this->project_id);
        $subject = $project->Subject;
        $subject_project = $subject->Project->load(['Grade' => function ($query) {
            return $query->where('user_id', auth()->user()->id);
        }]);
        if(! Gate::allows('user_subscribed_subject', Subject::findOrFail($subject->id))){
            return false;
        }
        if($subject_project->pluck('Grade')->collapse()->count() >= config('settings.max_grade_add')){
            return false;
        }
        if($project->Grade->count() >= config('settings.grade_for_project')){
            return false;
        }
        if($project->user_id == auth()->user()->id){
            return false;
        }
        if($project->Grade->where('user_id', auth()->user()->id)->count() != 0){
            return false;
        }
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'project_id' => 'required|exists:projects,id',
            'grade' => 'required|integer|in:1,2,3',
        ];
    }
}
