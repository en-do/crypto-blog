<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckExpired
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        $date = Carbon::now();

        if($user->cannot('profile.expired')) {
            if ( isset($user->expired_at) and $user->expired_at->lte($date) ) {
                Auth::logout();

                $date = $user->expired_at->format('d/m/Y');

                return redirect()->route('login')->withErrors(['permission' => "Your permission has expired: $date"]);
            }
        }

        return $next($request);
    }
}
