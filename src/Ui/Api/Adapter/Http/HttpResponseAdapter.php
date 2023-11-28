<?php

declare(strict_types=1);

namespace Core\Ui\Api\Adapter\Http;

class HttpResponseAdapter
{
    public function __construct(protected int $statusCode, protected $body)
    {
    }

    public function getBody()
    {
        return $this->body;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}