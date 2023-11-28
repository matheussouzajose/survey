<?php

declare(strict_types=1);

namespace Core\Main\Config;

use Slim\Factory\AppFactory;

class App
{
    public function __invoke(): void
    {
        $app = AppFactory::create();

        Middlewares::setup(app: $app);
        Routes::setup(app: $app);

        $app->run();
    }
}