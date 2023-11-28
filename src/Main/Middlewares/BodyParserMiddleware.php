<?php

declare(strict_types=1);

namespace Core\Main\Middlewares;

use Slim\App;

class BodyParserMiddleware
{
    public static function setup(App $app): void
    {
        $app->addBodyParsingMiddleware();
    }
}