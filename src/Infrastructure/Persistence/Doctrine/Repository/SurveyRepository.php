<?php

declare(strict_types=1);

namespace Core\Infrastructure\Persistence\Doctrine\Repository;

use Core\Domain\Survey\Repository\SurveyRepositoryInterface;
use Doctrine\ORM\EntityRepository;

class SurveyRepository extends EntityRepository implements SurveyRepositoryInterface
{

}