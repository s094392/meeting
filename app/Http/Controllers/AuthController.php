<?php

namespace App\Http\Controllers;

use GuzzleHttp;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private $_client_url;
    private $_client_id;
    private $_server_url;
    private $_client_secret;

    public function __construct(){
        $this->_client_url = env("CALLBACK_URL", null);
        $this->_client_id = env("CLIENT_ID", null);
        $this->_server_url = env("SERVER_URL", null);
        $this->_client_secret = env("CLIENT_SECRET", null);
    
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirect()
    {
        $query = http_build_query([
            'client_id' => $this->_client_id,
            'redirect_uri' => $this->_client_url,
            'response_type' => 'code',
            'scope' => 'profile',
        ]);
        return redirect($this->_server_url.'/oauth/authorize?'.$query);
    }

    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function callback(Request $request)
    {
        $config = ['verify' => false ];
        $http = new GuzzleHttp\Client($config);
        $response = $http->post($this->_server_url.'/oauth/token', [
            'form_params' => [
                'grant_type' => 'authorization_code',
                'client_id' => $this->_client_id,
                'client_secret' => $this->_client_secret,
                'redirect_uri' => $this->_client_url,
                'code' => $request->code,
                ]
            ]
        );
        return $this->getUser(json_decode((string) $response->getBody(), true)["access_token"]);
    }

    public function getUser($access_token)
    {
        $http = new GuzzleHttp\Client();
        $auth = "Bearer {$access_token}";
        error_log($auth);

        $response = $http->get($this->_server_url.'/api/me', [
            'headers' => [
                'Authorization' => $auth,
                ]
            ]
        );
        return json_decode((string) $response->getBody(), true);
    }
}
