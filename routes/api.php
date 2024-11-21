<?php

use Illuminate\Support\Facades\Route;

/**
 * Define API routes with a prefix of /api/v1.
 *
 * @note To view the routes, use the command `php artisan route:list`
 *       or `php artisan route:list --path=api/v1` in the terminal.
 *
 * @see \bootstrap\app.php for configuration details
 */
Route::prefix('v1')->group(base_path('routes/api/api_v1.php'));
