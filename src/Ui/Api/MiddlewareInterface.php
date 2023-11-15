<?php

declare(strict_types=1);

namespace Core\Ui\Api;

use Core\Ui\Api\Adapter\Http\HttpResponseAdapter;

interface MiddlewareInterface
{
    public function __invoke(object $request): HttpResponseAdapter;
}