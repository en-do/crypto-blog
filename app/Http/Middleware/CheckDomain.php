<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Domain;

class CheckDomain
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
        $host = $request->getHost();
        $domains = Domain::where('status', 'published')->get();

        $domain = $domains->filter(function($item) use($host) {
            return $item->host == $host;
        })->first();

        if(isset($domain->template)) {
            app()->instance('template', $domain->template);
            app()->instance('domain_id', $domain->id);

            return $next($request);
        }

        abort(404);
    }
}
