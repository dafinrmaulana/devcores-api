<?php

namespace App\Http\Controllers\APi\V1\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\ProfileUpdateRequest;
use App\Http\Resources\ProfileResource;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $profile = Profile::where("user_id", Auth::id())->with('user')->first();
        return (new ProfileResource($profile))
            ->setSuccess(true)
            ->setMessage('Profile retrieved successfully')
            ->setStatusCode(200)
            ->response();
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Profile\ProfileUpdateRequest  $request
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ProfileUpdateRequest $request)
    {
        $profile = Profile::where("user_id", Auth::id())->first();
        $profile->update($request->data($profile));
        return (new ProfileResource($profile->with('user')->find(Auth::id())))
            ->setSuccess(true)
            ->setMessage("Profile updated successfully")
            ->setStatusCode(200)
            ->response();
    }
}
