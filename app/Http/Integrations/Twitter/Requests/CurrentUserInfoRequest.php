<?php

namespace App\Http\Integrations\Twitter\Requests;

use Illuminate\Support\Arr;
use Saloon\Enums\Method;
use Saloon\Http\Request;

class CurrentUserInfoRequest extends Request
{
    /**
     * Define the HTTP method
     *
     * @var Method
     */
    protected Method $method = Method::GET;

    /**
     * Define the endpoint for the request
     *
     * @return string
     */
    public function resolveEndpoint(): string
    {
        return '/users/me';
    }

    protected function defaultQuery(): array
    {
        return [
            'user.fields' => Arr::join([
                'created_at',
                'description',
                'entities',
                'id',
                'location',
                'name',
                'pinned_tweet_id',
                'profile_image_url',
                'protected',
                'url',
                'username',
                'verified',
                'withheld',
            ], ','),
        ];
    }
}
