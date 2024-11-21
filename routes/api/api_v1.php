<?php

use App\Http\Controllers\Api\v1\Account\AccountController;
use App\Http\Controllers\Api\v1\Auth\AuthController;
use App\Http\Controllers\Api\v1\Admin\Template\TemplateController;
use App\Http\Controllers\APi\V1\Profile\ProfileController;
use App\Http\Controllers\Api\v1\User\Project\ProjectController;
use App\Http\Controllers\Api\v1\User\Skill\SkillController;
use Illuminate\Support\Facades\Route;

Route::post("/register", [AuthController::class, "register"]);
Route::post("/login", [AuthController::class, "login"])->name("login");

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post("/logout", [AuthController::class, "logout"]);

    // profile
    Route::get('/profiles', [ProfileController::class, "index"]);
    Route::put('/profiles', [ProfileController::class, "update"]);

    // account
    Route::get('/account', [AccountController::class, 'index']);
    Route::put('/account/password', [AccountController::class, "updatePassword"]);
    Route::put('/account/email', [AccountController::class, "updateEmail"]);

    // projects
    Route::apiResource("projects", ProjectController::class);

    // projects
    Route::apiResource("skills", SkillController::class);

    Route::group(["middleware" => "role:admin", "prefix" => "admin"], function () {
        Route::apiResource("templates", TemplateController::class);
    });
});
