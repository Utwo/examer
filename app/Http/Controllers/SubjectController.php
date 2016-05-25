<?php

namespace App\Http\Controllers;

use App\Subject;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subjects = Subject::where('user_id', auth()->user()->id)->get();
        return view('admin.subject')->withSubjects($subjects);
    }

    public function update(Request $request)
    {
        $subject = Subject::findOrFail($request->id);
        $subject->update($request->all());
        return redirect()->route('get_subject');
    }
}
