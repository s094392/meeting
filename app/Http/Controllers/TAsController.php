<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp;

class TAsController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $server_url = env("CSSSO_SERVER", null);
        $http = new GuzzleHttp\Client();
        $response = $http->get($server_url.'/api/tas');
        return json_decode((string) $response->getBody(), true);
    }
}
