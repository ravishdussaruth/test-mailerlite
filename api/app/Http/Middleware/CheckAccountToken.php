<?php

namespace App\Http\Middleware;


use Illuminate\Auth\AuthenticationException;
use Laravel\Passport\Http\Middleware\CheckClientCredentials;

class CheckAccountToken extends CheckClientCredentials
{
    /**
     * Validate token credentials.
     *
     * @param  \Laravel\Passport\Token $token
     *
     * @return void
     *
     * @throws AuthenticationException
     */
    protected function validateCredentials($token)
    {
        if (!$token || !request()->account->hasClientAssociated($token->client_id)) {
            throw new AuthenticationException;
        }
    }
}
