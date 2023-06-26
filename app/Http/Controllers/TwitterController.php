<?php

namespace App\Http\Controllers;

use App\Http\Integrations\Twitter\Requests\CreateTweetRequest;
use App\Http\Integrations\Twitter\Requests\CurrentUserInfoRequest;
use App\Http\Integrations\Twitter\TwitterConnector;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;

class TwitterController extends Controller
{
    public function handleAuthorization(Request $request): RedirectResponse
    {
        $connector = new TwitterConnector();
        $authorizationUrl = $connector->getAuthorizationUrl(
            additionalQueryParameters: [
                'code_challenge_method' => 'plain',
                'code_challenge' => 'challenge',
            ],
        );

        Session::put('twitterAuthState', $connector->getState());

        return redirect()->away($authorizationUrl);
    }

    public function handleCallback(Request $request)
    {
        $code = $request->input('code');
        $state = $request->input('state');

        $connector = new TwitterConnector();

        $expectedState = Session::pull('twitterAuthState');

        logger([
            '$expectedState' => $expectedState,
            'code' => $code,
            '$state' => $state,
            'request' => $request->all(),
        ]);

        $authorization = $connector->getAccessToken($code, $state, $expectedState);

        $user = auth()->user();
        $user->twitter_auth = serialize($authorization);
        $user->save();

        $connector->authenticate($authorization);

        $response = $connector->send(new CurrentUserInfoRequest());

        dd([
            'response' => $response->collect(),
            'headers' => $response->headers(),
            'getAccessToken' => $authorization->getAccessToken(),
            'getRefreshToken' => $authorization->getRefreshToken(),
            'getExpiry' => $authorization->getExpiresAt(),
            'hasExpired' => $authorization->hasExpired(),
            'hasNotExpired' => $authorization->hasNotExpired(),
        ]);
    }

    public function index()
    {
        return Inertia::render('Twitter/Index');
    }

    public function tweet()
    {
        /** @var User $user */
        $user = Auth::user();
        $token = unserialize($user->twitter_auth);

        $connector = TwitterConnector::make()->authenticate($token);

        $response = $connector->send(new CreateTweetRequest('Tweet from Api V2'));

        dd([
            'response' => $response->collect(),
            'headers' => $response->headers(),
        ]);
    }
}
