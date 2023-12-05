<?php

declare(strict_types=1);

namespace Core\Ui\Api\Controller\Survey;

use Core\Application\UseCase\Survey\Add\AddSurveyInputDto;
use Core\Application\UseCase\Survey\Add\AddSurveyUseCase;
use Core\Domain\Shared\Exceptions\NotificationErrorException;
use Core\Ui\Api\Adapter\Http\HttpResponseAdapter;
use Core\Ui\Api\ControllerInterface;
use Core\Ui\Api\Validation\ValidationInterface;

class AddSurveyController implements ControllerInterface
{
    public function __construct(
        private readonly ValidationInterface $validation,
        private readonly AddSurveyUseCase $useCase
    ) {
    }


    /**
     * @throws NotificationErrorException
     */
    public function __invoke(object $request): HttpResponseAdapter
    {
        $error = $this->validation->validate(input: $request);
        if ( $error ) {
            return badRequest(error: $error);
        }

        $result = ($this->useCase)($this->createFromRequest(request: $request));
        return ok($result);
    }

    private function createFromRequest(object $request): AddSurveyInputDto
    {
        return new AddSurveyInputDto(
            question: $request->question,
            surveyAnswers: $request->answers
        );
    }
}