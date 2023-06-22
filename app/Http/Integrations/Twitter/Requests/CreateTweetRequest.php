<?php

namespace App\Http\Integrations\Twitter\Requests;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class CreateTweetRequest extends Request implements HasBody
{
    use HasJsonBody;

    /**
     * Define the HTTP method
     *
     * @var Method
     */
    protected Method $method = Method::POST;

    protected string $text;

    public function __construct(string $text)
    {
        $this->text = $text;
    }

    /**
     * Define the endpoint for the request
     *
     * @return string
     */
    public function resolveEndpoint(): string
    {
        return '/tweets';
    }

    protected function defaultBody(): array
    {
        return [
            'text' => $this->text
        ];
    }
}
