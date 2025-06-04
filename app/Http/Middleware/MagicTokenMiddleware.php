<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Department;
use Illuminate\Support\Facades\Auth;

class MagicTokenMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!$token = $request->header('X-MAGIC-TOKEN')) {
            return response()->json(['error' => 'Missing magic token'], 401);
        }

        if (!$department = Department::where('magic_token', $token)->first()) {
            return response()->json(['error' => 'Invalid magic token'], 401);
        }

        Auth::setUser($department);

        return $next($request);
    }
}