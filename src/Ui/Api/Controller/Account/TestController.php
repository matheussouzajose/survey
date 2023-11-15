<?php

namespace Core\Ui\Api\Controller\Account;

use Core\Ui\Api\Adapter\Http\HttpResponseAdapter;
use Core\Ui\Api\Adapter\Http\HttpResponseHelper;
use Core\Ui\Api\ControllerInterface;

class TestController implements ControllerInterface
{

    public function __invoke(object $request): HttpResponseAdapter
    {
        return HttpResponseHelper::ok((array)$request);
    }
}