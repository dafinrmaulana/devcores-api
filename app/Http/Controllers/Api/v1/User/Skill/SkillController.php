<?php

namespace App\Http\Controllers\Api\v1\User\Skill;

use App\Http\Controllers\Controller;
use App\Http\Requests\Skill\SkillStoreRequest;
use App\Http\Requests\Skill\SkillUpdateRequest;
use App\Http\Resources\SkillResource;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SkillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $skills = Skill::whereHas("profile", function ($query) {
            $query->where("user_id", Auth::id());
        })
            ->orderBy("name", "asc")
            ->paginate(20);

        return (new SkillResource($skills))
            ->setSuccess(true)
            ->setMessage("Skill retrieved successfully")
            ->response();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SkillStoreRequest $request)
    {
        $skills = Skill::create($request->data());
        return (new SkillResource($skills))
            ->setSuccess(true)
            ->setMessage("Skill created successfully")
            ->setStatusCode(201)
            ->response();
    }

    /**
     * Display the specified resource.
     */
    public function show(Skill $skill)
    {
        $skill->load("profile");
        if ($skill->profile->user_id != Auth::id()) {
            return (new SkillResource([]))
                ->setSuccess(false)
                ->setMessage("You are not authorized to view this project")
                ->setStatusCode(403)
                ->response();
        }
        return (new SkillResource($skill))
            ->setSuccess(true)
            ->setMessage("Project retrieved successfully")
            ->response();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SkillUpdateRequest $request, Skill $skill)
    {
        $skill->update($request->data());
        return (new SkillResource($skill))
            ->setSuccess(true)
            ->setMessage("Skill updated successfully")
            ->response();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Skill $skill)
    {
        $skill->delete();
        return (new SkillResource($skill))
            ->setSuccess(true)
            ->setMessage("Skill {$skill->name} deleted successfully")
            ->response();
    }
}
