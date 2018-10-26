<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Input;

class Auth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $api = '')
    {
        if (!session()->get('user')['groups']) {
            if ($api) {
                return response('', 401);
            }
            session([ 'redirect_url' => $request->path() ]);
            return redirect('/cssso/redirect');
        };
        if (session()->get('user')['groups']
            && !in_array("cs-ta", session()->get('user')['groups'])) {
            if ($api) {
                    return response(['message' => '你沒權限'], 403);
            }
            return redirect('/login');
        }
        return $next($request);
    }
}
