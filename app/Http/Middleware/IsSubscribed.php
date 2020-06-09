<?php

namespace App\Http\Middleware;

use Closure;

class IsSubscribed
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->user() && !$request->user()->subscribed('default')) {
            $request->session()->flash('error', 'You have to subscribe to access this content');

            // This user is not a paying customer...
            return redirect()->route('account.subscription.index');
        }

        return $next($request);
    }
}
