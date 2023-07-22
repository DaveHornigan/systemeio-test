<?php

namespace App\Dto\Response;

use Symfony\Component\HttpFoundation\Response;

class ValidationErrorResponse
{
    /** @param array<string, string> $errors */
    public function __construct(
        public readonly int $code = Response::HTTP_UNPROCESSABLE_ENTITY,
        public readonly string $message = 'Validation Error.',
        public readonly array $errors = [],
    ) { }
}
