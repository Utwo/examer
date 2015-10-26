<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Project;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller {

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProjectRequest $request)
    {
        if ($request->hasFile('upload') && $request->file('upload')->isValid()) {
            $extension = $request->file('upload')->getClientOriginalExtension();
            $file_name = $request->file('upload')->getClientOriginalName();

            $project = Project::create(['name' => $file_name, 'extension' => $extension, 'user_id' => Auth::id()]);
            Storage::put('/projects/' . $project->id . '.' . $extension,
                file_get_contents($request->file('upload')->getRealPath()));
            $request->session()->flash('notification', 'Upload successful');
            return redirect()->back();
        } else {
            return redirect()->back()->withInput()->withErrors('No file selected');
        }
    }

    /**
     * Download a resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function download(Request $request)
    {
        $project = Project::findOrFail($request->id);
        $real_path = storage_path() . '/app/projects/' . $project->id . '.' . $project->extension;

        if (file_exists($real_path)) {
            return response()->download($real_path, $project->name);
        }else{
            return redirect()->back()->withErrors('File not found.');
        }
    }
}
