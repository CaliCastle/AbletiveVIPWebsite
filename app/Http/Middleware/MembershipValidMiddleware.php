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
            $user = Auth::user();
            Auth::logout();

            $user->delete();

            return redirect()->guest('login')
                ->withInput(['name' => $user->name])
                ->withErrors([
                    'name' => '会员已过期, 如果已经续费请重新登录'
                ]);
        }

        return $next($request);
    }
}
