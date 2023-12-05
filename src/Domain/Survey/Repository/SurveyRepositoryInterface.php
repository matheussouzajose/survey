<?php

declare(strict_types=1);

namespace Core\Domain\Survey\Repository;

use Core\Domain\Survey\Entity\Survey;

interface SurveyRepositoryInterface
{
    public function add(Survey $survey): Survey;
}