<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Http\Request;

use App\Http\Requests\UpdateProjectSettings;
use App\Http\Controllers\Controller;

class ProjectController extends Controller
{
    public function show(Request $request)
    {
        return view('teamwork.settings.project', [
            'project' => $request->user()->currentTeam()->first()
        ]);
    }

    public function update(UpdateProjectSettings $request)
    {
        $project = $request->user()->currentTeam()->first();

        $project->project_name = $request->get('project_name');
        $project->site_url = $request->get('site_url');
        $project->dir_images = $request->get('dir_images');
        $project->save();

        return back()->with(['status' => trans('notifications.changes_saved'), 'type' => 'success', 'timeout' => '2000']);
    }
}
