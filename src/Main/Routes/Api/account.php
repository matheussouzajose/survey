<?php

use Core\Main\Adapters\SlimMiddlewareAdapter;
use Core\Main\Adapters\SlimRouteAdapter;
use Core\Main\Factories\Controller\Account\SignInControllerFactory;
use Core\Main\Factories\Controller\Account\SignUpControllerFactory;
use Core\Main\Factories\Middleware\AuthMiddlewareFactory;
use Core\Ui\Api\Controller\Account\TestController;
use Slim\Routing\RouteCollectorProxy;

return function (RouteCollectorProxy $app) {
    $app->post('/v1/sign-up', new SlimRouteAdapter(controller: SignUpControllerFactory::create()));
    $app->post('/v1/sign-in', new SlimRouteAdapter(controller: SignInControllerFactory::create()));
    $app->post('/v1/teste', new SlimRouteAdapter(controller: new TestController()))->add(middleware: new SlimMiddlewareAdapter(AuthMiddlewareFactory::create()));
};