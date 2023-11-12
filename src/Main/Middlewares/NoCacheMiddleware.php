<?php

declare(strict_types=1);

namespace Core\Main\Middlewares;

use Slim\App;

class NoCacheMiddleware
{
    public static function setup(App $app): void
    {
        $app->add(function ($request, $handler) {
            $response = $handler->handle($request);
            return $response
                ->withHeader('cache-control', 'no-store, no-cache, must-revalidate, proxy-revalidate')
                ->withHeader('pragma', 'no-cache')
                ->withHeader('expires', '0')
                ->withHeader('surrogate-control', 'no-store');
        });
    }
}