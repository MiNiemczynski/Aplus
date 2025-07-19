<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleAuthorizationMiddleware
{
    public function handle(Request $request, Closure $next, string $roles): Response
    {
        $user = auth()->user();

        if (!$user) {
            abort(401, 'Unauthorized entrance - You must log in');
        }

        $roles = explode(',', $roles);
        foreach($roles as $role) {
            if ($user->hasRole($role)) {
                return $next($request);
            }
        }
        abort(403, 'Access denied – You are not a  ' . $role);
    }

}
