<?php

namespace Core\Main\Adapters;

use Core\Ui\Api\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

class SlimMiddlewareAdapter
{
    public function __construct(protected MiddlewareInterface $middleware)
    {
    }

    public function __invoke(Request $request, RequestHandler $handler): ResponseInterface
    {
        $httpResponse = ($this->middleware)((object)$request->getHeaders());
        if ($httpResponse->getStatusCode() === 200) {
            $request = $request->withAttribute('userId', $httpResponse->getBody());
            return $handler->handle($request);
        }

        $response = new Response();
        $errorResponse = ['error' => $httpResponse->getBody()];
        $response->getBody()->write(json_encode($errorResponse));
        return $response->withStatus($httpResponse->getStatusCode());
    }
}



