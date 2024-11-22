<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        "success" => true,
        "message" => "Server is running!",
        "status" => "Development"
    ], 200);
});
