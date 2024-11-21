<?php

namespace App\Http\Controllers\Api\v1\User\Project;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\ProjectStoreRequest;
use App\Http\Requests\Project\ProjectUpdateRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::with("profile")
            ->whereHas("profile", function ($query) {
                $query->where("user_id", Auth::id());
            })
            ->orderBy("title", "asc")
            ->paginate(20);

        return (new ProjectResource($projects))
            ->setSuccess(true)
            ->setMessage("Project retrieved successfully")
            ->response();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProjectStoreRequest $request)
    {
        $projects = Project::create($request->data());
        return (new ProjectResource($projects))
            ->setSuccess(true)
            ->setMessage("Project created successfully")
            ->setStatusCode(201)
            ->response();
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        $project->load("profile");
        if ($project->profile->user_id != Auth::id()) {
            return (new ProjectResource([]))
                ->setSuccess(false)
                ->setMessage("You are not authorized to view this project")
                ->setStatusCode(403)
                ->response();
        }
        return (new ProjectResource($project))
            ->setSuccess(true)
            ->setMessage("Project retrieved successfully")
            ->response();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProjectUpdateRequest $request, Project $project)
    {
        $project->update($request->data());
        return (new ProjectResource($project))
            ->setSuccess(true)
            ->setMessage("Project updated successfully")
            ->response();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        if ($project->thumbnail) {
            Storage::delete($project->thumbnail);
        }
        $project->delete();
        return (new ProjectResource($project))
            ->setSuccess(true)
            ->setMessage("Project {$project->name} deleted successfully")
            ->response();
    }
}
