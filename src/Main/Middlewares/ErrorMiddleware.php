<?php

declare(strict_types=1);

namespace Core\Main\Middlewares;

use Psr\Http\Message\ServerRequestInterface;
use Slim\App;
use Slim\Exception\HttpMethodNotAllowedException;
use Slim\Exception\HttpNotFoundException;
use Slim\Psr7\Response;

class ErrorMiddleware
{
    public static function setup(App $app): void
    {
        $errorMiddleware = $app->addErrorMiddleware(true, true, true);
        $errorHandler = $errorMiddleware->getDefaultErrorHandler();
        $errorHandler->forceContentType('application/json');

        $errorMiddleware->setErrorHandler(
            HttpNotFoundException::class,
            function (ServerRequestInterface $request, \Throwable $exception, bool $displayErrorDetails) {
                $response = new Response();
                $response->getBody()->write(json_encode(['message' => '404 NOT FOUND']));
                return $response->withStatus(404)->withHeader('Content-Type', 'application/json');
            }
        );

        $errorMiddleware->setErrorHandler(
            HttpMethodNotAllowedException::class,
            function (ServerRequestInterface $request, \Throwable $exception, bool $displayErrorDetails) {
                $response = new Response();
                $response->getBody()->write(json_encode(['message' => '405 NOT ALLOWED']));

                return $response->withStatus(404)->withHeader('Content-Type', 'application/json');
            }
        );
    }
}