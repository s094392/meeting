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
    public function grouped()
    {
        $server_url = env("CSSSO_SERVER", null);
        $http = new GuzzleHttp\Client();
        $response = $http->get($server_url.'/api/tas');
        $response = json_decode((string) $response->getBody(), true);
        foreach ($response as &$group) {
            foreach ($group as &$ta) {
                $ta["username"] = $ta["uid"];
                $ta["user_id"] = $ta["id"];
                unset($ta["id"]);
                unset($ta["uid"]);
            }
        }
        return $response;
    }

    public function list()
    {
        $groupedTas = $this->grouped();
        $tas = [];
        foreach ($groupedTas as $val) {
            $tas = array_merge($tas, $val);
        }
        $tas = array_values(array_unique($tas, SORT_REGULAR));
        return $tas;
    }

    public function map()
    {
        $tas = $this->list();
        $taMap = [];
        foreach ($tas as $val) {
            $taMap[$val["user_id"]] = $val["username"];
        }
        return $taMap;
    }
}
