<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class MembershipValidMiddleware
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
        if ($request->user()->membershipExpired()) {
            Auth::logout();
            return redirect()->guest('login')
                ->withInput(['name' => Auth::user()->name])
                ->withErrors([
                    'name' => '会员已过期'
                ]);
        }

        return $next($request);
    }
}
