<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp;
use Illuminate\Support\Facades\Input;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        if (!Input::get("expired") && session()->get('user')['id']) {
            return redirect("/");
        }
        return view('login', ["APP_URL" => env("APP_URL", ""),
                                "expired"=> Input::get("expired"),
                                "csTaOnly"=> Input::get("cs-ta-only")]);
    }
}
