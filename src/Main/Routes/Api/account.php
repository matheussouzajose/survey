<?php

use Core\Main\Adapters\SlimAdapterRouter;
use Core\Main\Factories\Controller\Account\SignUpControllerFactory;
use Slim\Routing\RouteCollectorProxy;

return function (RouteCollectorProxy $app) {
    $app->post('/v1/sign-up', new SlimAdapterRouter(controller: SignUpControllerFactory::create()));
};