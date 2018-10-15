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
        if (Input::get("expired") ||
        !session()->get('user')['groups'] ||
        !in_array("cs-ta", session()->get('user')['groups'])) {
            if ($api) {
                return response('', 401);
            }
            session([ 'redirect_url' => $request->path() ]);
            $params = ['expired'=>Input::get("expired")];
            if (session()->get('user')['groups'] &&
                !in_array("cs-ta", session()->get('user')['groups'])) {
                $params["cs-ta-only"] = true;
            }
            session()->forget('user');
            return redirect()->route('login', $params);
        };
        return $next($request);
    }
}
