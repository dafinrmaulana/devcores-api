<?php

namespace App\Providers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Response::macro('failed_json', function (
            int $statusCode = 404,
            string $message = "Resource not found"
        ): JsonResponse {
            $response = [
                'success' => false,
                'message' => $message,
            ];

            return response()->json($response, $statusCode);
        });
    }
}
