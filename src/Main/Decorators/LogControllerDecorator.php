<?php

declare(strict_types=1);

namespace Core\Main\Decorators;

use Core\Ui\Api\Adapter\Http\HttpResponseAdapter;
use Core\Ui\Api\ControllerInterface;

class LogControllerDecorator implements ControllerInterface
{
    public function __construct(private readonly ControllerInterface $controller)
    {
    }

    public function __invoke(object $request): HttpResponseAdapter
    {
        $httpResponse = ($this->controller)($request);
        if ( $httpResponse->getStatusCode() === 500 ) {
        }

        return $httpResponse;
    }
}