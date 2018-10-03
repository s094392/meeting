<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp;
use Illuminate\Support\Facades\Input;
use App\User;

class SSOController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $user = $request->session()->get('user');
        $user["user_id"] = $user["id"];
        $user["username"] = $user["uid"];
        User::updateOrCreate(["id" => $user["id"], "username" => $user["username"]]);
        $request->session()->put('user', $user);
        $url = $request->session()->get('redirect_url');
        if ($url) {
            $request->session()->forget('redirect_url');
            return redirect($url);
        }
        return redirect("/");
    }
}
