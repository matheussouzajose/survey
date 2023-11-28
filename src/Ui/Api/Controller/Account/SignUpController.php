<?php

declare(strict_types=1);

namespace Core\Ui\Api\Controller\Account;

use Core\Application\Exception\ValidationFailedException;
use Core\Application\UseCase\Account\SignUp\SignUpInputDto;
use Core\Application\UseCase\Account\SignUp\SignUpUseCase;
use Core\Domain\Account\Exceptions\EmailAlreadyInUseException;
use Core\Domain\Shared\Exceptions\NotificationErrorException;
use Core\Ui\Api\Adapter\Http\HttpResponseAdapter;
use Core\Ui\Api\Adapter\Http\HttpResponseHelper;
use Core\Ui\Api\ControllerInterface;

class SignUpController implements ControllerInterface
{
    public function __construct(private readonly SignUpUseCase $useCase)
    {
    }

    public function __invoke(object $request): HttpResponseAdapter
    {
        try {
            $response = ($this->useCase)(input: $this->createFromRequest(request: $request));
            return HttpResponseHelper::created((array)$response);
        } catch (\Throwable $e) {
            return $this->handleApplicationException($e);
        }
    }

    private function createFromRequest(object $request): SignUpInputDto
    {
        return new SignUpInputDto(
            firstName: $request->first_name ?? '',
            lastName: $request->last_name ?? '',
            email: $request->email ?? '',
            password: $request->password ?? '',
            passwordConfirmation: $request->password_confirmation ?? '',
        );
    }

    private function handleApplicationException(\Exception $e): HttpResponseAdapter
    {
        $error = $e->getMessage();
        return match (true) {
            $e instanceof ValidationFailedException => HttpResponseHelper::unprocessable(errors: json_decode($error)),
            $e instanceof NotificationErrorException => HttpResponseHelper::unprocessable(errors: $error),
            $e instanceof EmailAlreadyInUseException => HttpResponseHelper::conflict(error: $error),
            default => HttpResponseHelper::serverError($e),
        };
    }
}