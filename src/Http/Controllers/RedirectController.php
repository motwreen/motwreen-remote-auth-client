<?php

namespace Motwreen\Consumer\Http\Controllers;

use Illuminate\Http\Request;

class RedirectController extends Controller
{
    public function redirect(Request $request)
    {
        //Check if we have a valid access token
        if(session()->has('access_token'))
            return redirect('/');

        //Generate Url
        $url = trim(config('consumer.auth_server_url'), '/');
        $url = $url . '/' . trim(config('consumer.auth_server_oauth_path'), '/') . '/' . 'authorize/';

        //Auth Server Configuration
        $callback = config('consumer.auth_server_callback_url');
        $client_id = config('consumer.auth_server_client_id');
        //merge scopes
        $scopes = implode(" ", config('consumer.auth_server_scopes'));

        //Hash redirect to into base64
        $state = urlencode(base64_encode($request->get('pervious')));
        //Generate Url
        $res = sprintf(
            "%s?client_id=%s&redirect_uri=%s&response_type=code&scope=%s&state=%s",
            $url, $client_id, $callback, $scopes, $state
        );
        //Redirect to generated url
        return redirect($res);
    }
}
