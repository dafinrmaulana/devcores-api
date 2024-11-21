<?php

namespace App\Http\Controllers\Api\v1\Account;

use App\Http\Controllers\Controller;
use App\Http\Requests\Account\EmailUpdateRequest;
use App\Http\Requests\Account\PasswordUpdateRequest;
use App\Http\Resources\AccountResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function index()
    {
        return (new AccountResource(Auth::user()))
            ->setSuccess(true)
            ->setMessage("Account retrieved successfully")
            ->setStatusCode(200)
            ->response();
    }

    public function updatePassword(PasswordUpdateRequest $request)
    {
        $user = User::find(Auth::id());
        $user->update($request->validated());
        return (new AccountResource($user))
            ->setSuccess(true)
            ->setMessage("Password updated successfully")
            ->setStatusCode(200)
            ->response();
    }

    public function updateEmail(EmailUpdateRequest $request)
    {
        $user = User::find(Auth::id());
        if ($request->validated('current_email') !== $user->email) {
            return (new AccountResource([]))
                ->setSuccess(false)
                ->setMessage('Current email does not match')
                ->setStatusCode(422)
                ->response();
        }
        $user->update($request->validated());
        return (new AccountResource($user))
            ->setSuccess(true)
            ->setMessage("Email updated successfully")
            ->setStatusCode(200)
            ->response();
    }
}
