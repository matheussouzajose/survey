<?php

declare(strict_types=1);

namespace Core\Ui\Api\Controller\Account;

use Core\Application\Exception\InvalidCredentialsException;
use Core\Application\Exception\ValidationFailedException;
use Core\Application\UseCase\Account\SignIn\SignInInputDto;
use Core\Application\UseCase\Account\SignIn\SignInUseCase;
use Core\Domain\Shared\Exceptions\NotificationErrorException;
use Core\Ui\Api\Adapter\Http\HttpResponseAdapter;
use Core\Ui\Api\Adapter\Http\HttpResponseHelper;
use Core\Ui\Api\ControllerInterface;

class SignInController implements ControllerInterface
{
    public function __construct(private readonly SignInUseCase $useCase)
    {
    }

    public function __invoke(object $request): HttpResponseAdapter
    {
        try {
            $response = ($this->useCase)(input: $this->createFromRequest(request: $request));
            return HttpResponseHelper::ok((array)$response);
        } catch (\Throwable $e) {
            return $this->handleApplicationException($e);
        }
    }

    private function createFromRequest(object $request): SignInInputDto
    {
        return new SignInInputDto(
            email: $request->email ?? '',
            password: $request->password ?? '',
        );
    }

    private function handleApplicationException($e): HttpResponseAdapter
    {
        $error = $e->getMessage();
        return match (true) {
            $e instanceof ValidationFailedException => HttpResponseHelper::unprocessable(errors: json_decode($error)),
            $e instanceof NotificationErrorException => HttpResponseHelper::unprocessable(errors: $error),
            $e instanceof InvalidCredentialsException => HttpResponseHelper::unauthorized(),
            default => HttpResponseHelper::serverError(),
        };
    }
}