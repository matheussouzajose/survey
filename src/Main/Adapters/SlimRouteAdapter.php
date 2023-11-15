<?php

namespace Core\Main\Adapters;

use Core\Ui\Api\ControllerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Http\Interfaces\ResponseInterface;

class SlimRouteAdapter
{
    public function __construct(protected ControllerInterface $controller)
    {
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, $args): ResponseInterface
    {
        $requestData = array_merge(
            $args,
            $request->getParsedBody() ?? [],
            $request->getAttribute('userId') ?? []
        );

        $httpResponse = ($this->controller)(request: (object)$requestData);
        if ( $httpResponse->getStatusCode() >= 200 && $httpResponse->getStatusCode() <= 299 ) {
            $response->getBody()->write(json_encode($httpResponse->getBody()));
            return $response->withStatus($httpResponse->getStatusCode());
        }

        $errorResponse = ['error' => $httpResponse->getBody()];
        $response->getBody()->write(json_encode($errorResponse));
        return $response->withStatus($httpResponse->getStatusCode());
    }
}



