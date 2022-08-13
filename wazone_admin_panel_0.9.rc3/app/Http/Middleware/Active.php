<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;

class Active
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
        if ( $request->user()->role !== 'admin' && \Helper::isEx()) {
            if ((Carbon::now()->diffInseconds($request->user()->billing_end, false)) < 0) {
                $request->user()->package_id = 2;
                $request->user()->save();
                return redirect()->route('user.expired');
            }
        }
        return $next($request);
    }
}
