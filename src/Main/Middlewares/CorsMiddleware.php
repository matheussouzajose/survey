<?php

declare(strict_types=1);

namespace Core\Main\Middlewares;

use Slim\App;

class CorsMiddleware
{
    public static function setup(App $app): void
    {
        $app->add(function ($request, $handler) {
            $response = $handler->handle($request);
            return $response
                ->withHeader('Access-Control-Allow-Origin', '*')
                ->withHeader('Access-Control-Allow-Headers', '*')
                ->withHeader('Access-Control-Allow-Methods', '*');
        });
    }
}