<?php

declare(strict_types=1);

namespace Core\Main\Config;

use Core\Main\Middlewares\BodyParserMiddleware;
use Core\Main\Middlewares\ContentTypeMiddleware;
use Core\Main\Middlewares\CorsMiddleware;
use Core\Main\Middlewares\ErrorMiddleware;
use Slim\App;

class Middlewares
{
    public static function setup(App $app): void
    {
        BodyParserMiddleware::setup(app: $app);
        ContentTypeMiddleware::setup(app: $app);
        CorsMiddleware::setup(app: $app);
        ErrorMiddleware::setup(app: $app);
    }
}