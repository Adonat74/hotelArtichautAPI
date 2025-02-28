<?php

namespace App\Http\Middleware;

use App\Models\Role;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        $user = $request->user();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

//      get the required role for the route
        $requiredRole = Role::where('role_name', $role)->first();
        if (!$requiredRole) {
            return response()->json(['error' => 'Required role not defined'], 500);
        }

//      get the role of the user
        $userRole = $user->role;
        if (!$userRole) {
            return response()->json(['error' => 'User role not defined'], 500);
        }

//      Compare the priority of the two roles
        if ($userRole->priority < $requiredRole->priority) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        return $next($request);
    }
}
