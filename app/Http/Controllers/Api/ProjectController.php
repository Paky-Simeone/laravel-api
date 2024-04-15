<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::select('id', 'type_id', 'user_id', 'title', 'description', 'image_preview', )
        ->orderBy('updated_at', 'DESC')
        ->with(['type', 'technologies'])
        ->paginate();

        foreach ($projects as $project) {
            $project->image = !empty($project->image) ? asset('/storage/' . $project->image) : null;
            $project->description = $project->getAbstract(30);
        }

        return response()->json($projects);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $title
     * @return \Illuminate\Http\Response
     */
    public function show($title)
    {
        $project = Project::select('id', 'type_id', 'user_id', 'title', 'description', 'image_preview', )
        ->where('title', $title)
        ->with(['type', 'technologies'])
        ->first();

        $project->image = !empty($project->image) ? asset('/storage/' . $project->image) : null;
        $project->description = $project->getAbstract(30);

        return response()->json($project);
    }

}
