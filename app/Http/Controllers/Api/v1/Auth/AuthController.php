<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterStoreRequest;
use App\Http\Resources\AuthResource;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;

class AuthController extends Controller
{
    public function register(RegisterStoreRequest $request)
    {

        $user = User::create($request->data());
        Profile::create([
            'user_id' => $user->id,
            'template_id' => 1
        ]);
        $user = $user->with('profile')->find($user->id);
        return (new AuthResource($user))
            ->setSuccess(true)
            ->setMessage("Registration successful")
            ->setToken($user)
            ->setStatusCode(201)
            ->response();
    }

    public function login(LoginRequest $request)
    {
        $user = User::when($request->validated('email'), function ($query, $email) {
            $query->where('email', $email);
        })
            ->when($request->validated('username'), function ($query, $username) {
                $query->where('username', $username);
            })
            ->first();

        if (!$user || !Hash::check($request->validated("password"), $user->password)) {
            return (new AuthResource(null))
                ->setSuccess(false)
                ->setMessage("Invalid credentials")
                ->setStatusCode(401)
                ->response();
        }

        return (new AuthResource($user))
            ->setSuccess(true)
            ->setMessage("Login successful")
            ->setToken($user)
            ->setStatusCode(200)
            ->response();
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json([
            "success" => true,
            "message" => "Logout successful"
        ], 200);
    }
}
