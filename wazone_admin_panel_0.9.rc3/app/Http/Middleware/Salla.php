<?php


namespace App\Http\Middleware;


use Illuminate\Http\Request;

class Salla
{
    public function handle(Request $request, \Closure $next)
    {
        if ($request->header('HTTP_AUTHORIZATION') !== env('SALLA_TOKEN')) {
            return abort(403);
        }

        $event = $request->json()->get('event');
        $merchant = $request->json()->get('merchant');

        if (!$event || !$merchant) {
            return abort(404);
        }

        return $next($request);
    }
}
