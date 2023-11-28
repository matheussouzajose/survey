<?php

use Core\Main\Adapters\SlimRouteAdapter;
use Core\Main\Factories\Controller\Survey\AddSurveyControllerFactory;
use Core\Main\Factories\Controller\Survey\LoadSurveysControllerFactory;
use Slim\Routing\RouteCollectorProxy;

return function (RouteCollectorProxy $app) {
    $app->post('/v1/surveys', new SlimRouteAdapter(controller: AddSurveyControllerFactory::create()));
    $app->get('/v1/surveys', new SlimRouteAdapter(controller: LoadSurveysControllerFactory::create()));
};