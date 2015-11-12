<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Project;

class DeleteProjectRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $project = Project::with('Grade')->findOrFail($this->id);
        if($project->user_id != auth()->user()->id){
            return false;
        }
        if($project->Grade->count() > 0){
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
            'id' => 'required|integer|exists:projects'
        ];
    }
}
