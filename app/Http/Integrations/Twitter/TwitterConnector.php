<?php

namespace App\Http\Integrations\Twitter;

use Saloon\Helpers\OAuth2\OAuthConfig;
use Saloon\Http\Connector;
use Saloon\Http\OAuth2\GetAccessTokenRequest;
use Saloon\Http\Request;
use Saloon\Traits\OAuth2\AuthorizationCodeGrant;
use Saloon\Traits\Plugins\AcceptsJson;

class TwitterConnector extends Connector
{
    use AcceptsJson;
    use AuthorizationCodeGrant;

    /**
     * The Base URL of the API
     *
     * @return string
     */
    public function resolveBaseUrl(): string
    {
        return config('services.twitter.url');
    }

    public function defaultOauthConfig(): OAuthConfig
    {
        return OAuthConfig::make()
            ->setClientId(config('services.twitter.api_key'))
            ->setClientSecret(config('services.twitter.secret_key'))
            ->setDefaultScopes(['tweet.read', 'tweet.write', 'users.read', 'offline.access'])
            ->setRedirectUri('http://laravel-inertia.test/twitter/callback')
            ->setAuthorizeEndpoint('https://twitter.com/i/oauth2/authorize')
            ->setTokenEndpoint('https://api.twitter.com/2/oauth2/token')
            ->setRequestModifier(function (Request $request) {
                if ($request instanceof GetAccessTokenRequest) {
                    $request->body()->add('code_verifier', 'challenge');
                }
            });
    }

    /**
     * Default headers for every request
     *
     * @return string[]
     */
    protected function defaultHeaders(): array
    {
        return [];
    }

    /**
     * Default HTTP client options
     *
     * @return string[]
     */
    protected function defaultConfig(): array
    {
        return [];
    }
}
