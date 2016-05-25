<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Subject;
use Illuminate\Support\Facades\Gate;

class StoreProjectRequest extends Request {
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $projects = Subject::with(['Project' => function($query){
            return $query->where('user_id', auth()->user()->id);
        }])->findOrFail(request()->subject_id);
        if ($projects->count() < config('settings.max_project_upload') && Gate::allows('user_subscribed_subject', Subject::findOrFail(request()->subject_id))) {
            return true;
        }
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'subject_id' => 'required|integer|exists:subjects,id',
            'upload' => 'required|mimes:doc,docx,rtf,txt,pdf,ppt|max:' . config('filesystems.max_file_size')
        ];
    }
}
