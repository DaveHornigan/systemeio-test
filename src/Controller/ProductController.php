<?php

namespace App\Controller;

use App\Dto\Request\CalculateCostRequest;
use App\Dto\Response\PaymentCostResponse;
use App\Dto\Response\ValidationErrorResponse;
use App\Form\Type\CalculateCostType;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/product', 'product.')]
class ProductController
{
    public function __construct(
        private readonly FormFactoryInterface $formFactory
    ) {}

    #[Route('/calculate-cost', name: 'calculate-cost', methods: [Request::METHOD_POST])]
    public function calculateCost(Request $request): Response
    {
        $form = $this->formFactory->create(CalculateCostType::class, options: ['data_class' => CalculateCostRequest::class]);
        try {
            $requestData = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);
            $form->submit($requestData);
        } catch (\JsonException) {
            throw new BadRequestHttpException('Invalid json format.');
        }

        if ($form->isValid() === false) {
            /** @var list<FormError> $formErrors */
            $formErrors = $form->getErrors(true);
            $errors = [];
            foreach ($formErrors as $error) {
                $errors[$error->getOrigin()->getName()][] = $error->getMessage();
            }

            // Should be generated in ErrorHandler instead
            return new JsonResponse(new ValidationErrorResponse(errors: $errors), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $response = new PaymentCostResponse(0);

        return new JsonResponse($response, Response::HTTP_OK);
    }
}
