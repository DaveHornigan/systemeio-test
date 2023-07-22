<?php

namespace App\Exception;

use Exception;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ConstraintViolationHttpException extends Exception
{
    public function __construct(private readonly ConstraintViolationListInterface|array $violationList) {
        parent::__construct('Validation error.', Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function getErrors(): array
    {
        return is_array($this->violationList) ? $this->violationList : iterator_to_array($this->violationList);
    }
}
