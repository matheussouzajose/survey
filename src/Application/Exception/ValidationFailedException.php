<?php

namespace Core\Application\Exception;

final class ValidationFailedException extends \Exception
{
    /**
     * @var array
     */
    private $errors;

    public function __construct(array $errors)
    {
        parent::__construct('Validation failed');
        $this->errors = $errors;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}