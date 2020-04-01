<?php

namespace Motwreen\Consumer\Http\Controllers;

use Illuminate\Http\Request;
use Motwreen\Consumer\Repositories\TokenRepository;

class CallbackController extends Controller
{
    protected $tokenRepository;

    public function __construct(TokenRepository $tokenRepository)
    {
        $this->tokenRepository = $tokenRepository;
    }

    /**
     * Auth Callback
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function callback(Request $request)
    {
        // Extract url form state parameter
        $redirectTo = base64_decode(urldecode($request->get('state')));
        // Authorization Code
        $authorizationCode = $request->get('code');
        // Send Authorization Code to Auth Server to get access token
        $token = $this->tokenRepository->exchangeAuthorizationCodeForToken($authorizationCode);
        // Request Has Error
        if (isset($token['error']))
            return redirect(route('consumer.redirect'));
        // Put access token in session
        session()->put(config('consumer.token_holder'), $token['access_token']);
        // Redirect to extracted url
        return redirect($redirectTo);
    }

}
