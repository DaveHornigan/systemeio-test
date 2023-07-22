<?php

namespace App\EventListener;

use App\Exception\ConstraintViolationHttpException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class ExceptionListener
{
    public function __invoke(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        $responseData = [
            'message' => $exception->getMessage(),
            'code' => $exception->getCode() === 0 ? 500 : $exception->getCode()
        ];
        if ($exception instanceof ConstraintViolationHttpException) {
            $responseData['errors'] = $exception->getErrors();
        }

        $event->setResponse(new JsonResponse($responseData, $responseData['code']));
    }
}
