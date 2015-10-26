<?php

namespace App\Http\Controllers;

use App\Grade;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreGradeRequest;

class GradeController extends Controller
{


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGradeRequest $request)
    {
        $request->merge(['user_id' => Auth::id()]);
        Grade::create($request->all());
        $request->session()->flash('notification', 'Grade added');
        return redirect()->back();
    }
}
