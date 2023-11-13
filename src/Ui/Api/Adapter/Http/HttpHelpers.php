<?php

declare(strict_types=1);

namespace Core\Ui\Api\Adapter\Http;

class HttpHelpers
{
    public static function ok($data): HttpResponseAdapter
    {
        return new HttpResponseAdapter(statusCode: 200, body: $data);
    }

    public static function created($data): HttpResponseAdapter
    {
        return new HttpResponseAdapter(statusCode: 201, body: $data);
    }

    public static function noContent(): HttpResponseAdapter
    {
        return new HttpResponseAdapter(statusCode: 204, body: null);
    }

    public static function badRequest($error): HttpResponseAdapter
    {
        return new HttpResponseAdapter(statusCode: 204, body: $error);
    }

    public static function unauthorized(): HttpResponseAdapter
    {
        return new HttpResponseAdapter(statusCode: 204, body: 'UnauthorizedError');
    }

    public static function forbidden($error): HttpResponseAdapter
    {
        return new HttpResponseAdapter(statusCode: 403, body: $error);
    }

    public static function conflict($error): HttpResponseAdapter
    {
        return new HttpResponseAdapter(statusCode: 409, body: $error);
    }

    public static function unprocessable($errors): HttpResponseAdapter
    {
        return new HttpResponseAdapter(statusCode: 422, body: $errors);
    }

    public static function serverError($error): HttpResponseAdapter
    {
        return new HttpResponseAdapter(statusCode: 500, body: $error);
    }
}