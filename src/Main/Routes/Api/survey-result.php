<?php

use Core\Main\Adapters\SlimRouteAdapter;
use Core\Main\Factories\Controller\SurveyResult\LoadSurveyResultControllerFactory;
use Core\Main\Factories\Controller\SurveyResult\SaveSurveyResultControllerFactory;
use Slim\Routing\RouteCollectorProxy;

return function (RouteCollectorProxy $app) {
    $app->put(
        '/v1/surveys/{surveyId}/results',
        new SlimRouteAdapter(controller: SaveSurveyResultControllerFactory::create())
    );
    $app->get(
        '/v1/surveys/{surveyId}/results',
        new SlimRouteAdapter(controller: LoadSurveyResultControllerFactory::create())
    );
};