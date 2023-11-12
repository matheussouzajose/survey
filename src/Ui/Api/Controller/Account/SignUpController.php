<?php

declare(strict_types=1);

namespace Core\Ui\Api\Controller\Account;

use Core\Application\UseCase\Account\SignUp\SignUpInputDto;
use Core\Application\UseCase\Account\SignUp\SignUpUseCase;
use Core\Domain\Account\Exceptions\EmailAlreadyInUseException;
use Core\Domain\Shared\Exceptions\NotificationErrorException;
use Core\Ui\Api\Adapter\Http\HttpHelpers;
use Core\Ui\Api\Adapter\Http\HttpResponseAdapter;
use Core\Ui\Api\ControllerInterface;
use Core\Ui\Api\ValidatorRequestInterface;

class SignUpController implements ControllerInterface
{
    public function __construct(
        protected SignUpUseCase $useCase,
        protected ValidatorRequestInterface $validation
    ) {
    }

    public function __invoke(object $request): HttpResponseAdapter
    {
        try {
            if ( $errors = $this->validation->validate(input: $request) ) {
                return HttpHelpers::unprocessable(errors: $errors);
            }

            $response = ($this->useCase)(input: $this->createFromRequest(request: $request));

            return HttpHelpers::created((array)$response);
        } catch (EmailAlreadyInUseException|NotificationErrorException|\Exception $exception) {
            if ( $exception instanceof EmailAlreadyInUseException ) {
                return HttpHelpers::conflict(error: $exception->getMessage());
            }

            if ($exception instanceof NotificationErrorException) {
                return HttpHelpers::unprocessable(errors: $exception->getMessage());
            }

            return HttpHelpers::serverError(error: $exception->getMessage());
        }
    }

    private function createFromRequest(object $request): SignUpInputDto
    {
        return new SignUpInputDto(
            firstName: $request->first_name,
            lastName: $request->last_name,
            email: $request->email,
            password: $request->password,
        );
    }
}