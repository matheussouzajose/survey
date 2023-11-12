<?php

declare(strict_types=1);

namespace Core\Main\Middlewares;

use Slim\App;

class ContentTypeMiddleware
{
    public static function setup(App $app): void
    {
        $app->add(function ($request, $handler) {
            $response = $handler->handle($request);
            return $response
                ->withHeader('Content-Type', 'application/json');
        });
    }
}