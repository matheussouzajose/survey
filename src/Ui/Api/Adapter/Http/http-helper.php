<?php

declare(strict_types=1);


use Core\Ui\Api\Adapter\Http\HttpResponseAdapter;

function ok($data): HttpResponseAdapter
{
    return new HttpResponseAdapter(statusCode: 200, body: $data);
}

function created($data): HttpResponseAdapter
{
    return new HttpResponseAdapter(statusCode: 201, body: $data);
}

function noContent(): HttpResponseAdapter
{
    return new HttpResponseAdapter(statusCode: 204, body: null);
}

function badRequest($error): HttpResponseAdapter
{
    return new HttpResponseAdapter(statusCode: 404, body: $error);
}

function unauthorized(): HttpResponseAdapter
{
    return new HttpResponseAdapter(statusCode: 401, body: 'Unauthorized');
}

function forbidden(\Exception $error): HttpResponseAdapter
{
    return new HttpResponseAdapter(statusCode: 403, body: $error->getMessage());
}

function conflict($error): HttpResponseAdapter
{
    return new HttpResponseAdapter(statusCode: 409, body: $error);
}

function unprocessable($errors): HttpResponseAdapter
{
    return new HttpResponseAdapter(statusCode: 422, body: $errors);
}

function serverError($error = null): HttpResponseAdapter
{
    $body = [
        'message' => $error->getMessage(),
        'trace' => $error->getTrace()[0],
    ];

    return new HttpResponseAdapter(statusCode: 500, body: $body);
}
