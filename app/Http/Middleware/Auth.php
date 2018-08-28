<?php

namespace App\Http\Middleware;

use Closure;

class Auth
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
        error_log(session()->get('user')['uid']);
        if (!session()->get('user')['id']) {
            error_log("log in");
            session([ 'redirect_url' => $request->path() ]);
            return redirect('/cssso/redirect');
        };
        return $next($request);
    }
}
