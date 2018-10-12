<?php

namespace App\Http\Middleware;

use Closure;
use App\Meeting;

class MeetingPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  int $meeting_id
     * @return mixed
     */
    public function handle($request, Closure $next, $meeting_id)
    {
        $meeting = Meeting::where('id', $meeting_id);
        asdf;
        if (session('user')['user_id'] != $meeting->owner_id) {
            return response('', 403);
        };
        return $next($request);
    }
}
