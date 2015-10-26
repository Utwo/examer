<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class StoreProjectRequest extends Request {
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (auth()->user()->Project->count() >= 3) {
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
            'upload' => 'required|mimes:doc,docx,rtf,txt,pdf,ppt|max:' . config('filesystems.max_file_size')
        ];
    }
}
