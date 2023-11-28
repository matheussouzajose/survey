<?php

declare(strict_types=1);

namespace Core\Main\Decorators;

use Core\Domain\Shared\Repository\LogRepositoryInterface;
use Core\Ui\Api\Adapter\Http\HttpResponseAdapter;
use Core\Ui\Api\ControllerInterface;

class LogControllerDecorator implements ControllerInterface
{
    public function __construct(
        private readonly ControllerInterface $controller,
        private readonly LogRepositoryInterface $logRepositor
    ) {
    }

    public function __invoke(object $request): HttpResponseAdapter
    {
        $httpResponse = ($this->controller)($request);
        if ( $httpResponse->getStatusCode() === 500 ) {
            $this->logRepositor->logError($httpResponse->getBody());
        }

        return $httpResponse;
    }
}