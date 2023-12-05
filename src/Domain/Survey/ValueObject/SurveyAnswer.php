<?php

namespace Core\Domain\Survey\ValueObject;

use Core\Domain\Shared\ValueObject\Image;

class SurveyAnswer
{
    public function __construct(protected string $answer, protected ?Image $image = null)
    {
    }

    public function answer(): string
    {
        return $this->answer;
    }

    public function image(): ?Image
    {
        return $this->image ?? null;
    }
}