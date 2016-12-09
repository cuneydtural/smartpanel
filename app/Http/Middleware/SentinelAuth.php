<?php

namespace App\Http\Middleware;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Closure;

class SentinelAuth
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
        if(!Sentinel::check())
        {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                $notify[] = ['message' => 'Lütfen giriş yapın!', 'alert' => 'error'];
                return redirect()->route('admin.login')->withNotify($notify);
            }
        }
        return $next($request);
    }
}
