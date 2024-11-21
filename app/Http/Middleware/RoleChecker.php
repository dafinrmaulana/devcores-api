<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Response as HttpResponse;

class RoleChecker
{
    private const FALSE = 0;
    private const TRUE = 1;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        if ($request->user() && $request->user()->is_admin !== $this->roleSetter($role)) {
            return HttpResponse::failed_json(403, "Unauthorized");
        }
        return $next($request);
    }

    private function roleSetter($role)
    {
        if ($role === 'admin') {
            return $this::TRUE;
        }

        return $this::FALSE;
    }
}
