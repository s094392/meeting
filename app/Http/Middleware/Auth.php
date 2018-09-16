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
        if (Input::get("expired") || !session()->get('user')['id']) {
            if ($api) {
                return response('', 403);
            }
            session([ 'redirect_url' => $request->path() ]);
            return redirect()->route('login', ['expired'=>Input::get("expired")]);
        };
        return $next($request);
    }
}
