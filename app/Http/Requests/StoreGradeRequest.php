<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Support\Facades\Auth;
use App\Project;

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
        if($project->Grade->count() >= config('settings.max_grade_add')){
            return false;
        }
        if($project->user_id == Auth::id()){
            return false;
        }
        if($project->Grade->where('user_id', Auth::id())->count() != 0){
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
