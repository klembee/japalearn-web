<?php


namespace App\Http\Middleware;

/**
 * Check if the logged in user is of the given role
 * Class IsRole
 * @package App\Http\Middleware
 */
class IsRole
{
    public function handle($request, \Closure $next, $role){
        $user = $request->user();
        if(!$user) return redirect('login');
        if(!$user->hasRole($role)) return redirect('dashboard');


        return $next($request);
    }
}
