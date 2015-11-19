<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteProjectRequest;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Project;

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

            $project = Project::create(['name' => $request->name, 'extension' => $extension, 'user_id' => auth()->user()->id]);
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

        if (! file_exists($real_path)) {
            return redirect()->back()->withErrors('File not found.');
        }
        return response()->download($real_path, $project->name . '.' . $project->extension);
    }

    /**
     * Delete a resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function delete(DeleteProjectRequest $request)
    {
        $project = Project::findOrFail($request->id);
        $real_path = storage_path() . '/app/projects/' . $project->id . '.' . $project->extension;
        if (! file_exists($real_path)) {
            return redirect()->back()->withErrors('File not found.');
        }

        Storage::delete('/projects/' . $project->id . '.' . $project->extension);
        Project::destroy($project->id);
        $request->session()->flash('notification', 'Project deleted');
        return redirect()->back();
    }
}
