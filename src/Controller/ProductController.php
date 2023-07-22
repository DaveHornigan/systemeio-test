<?php

namespace App\Controller;

use App\Dto\Request\BuyProductRequest;
use App\Dto\Request\CalculateProductCostRequest;
use App\Dto\Response\PaymentCostResponse;
use App\Enum\PaymentProcessor;
use App\Exception\ConstraintViolationHttpException;
use App\Form\Type\BuyProductType;
use App\Form\Type\CalculateProductCostType;
use App\Service\Discount\DiscountInterface;
use App\Service\Discount\Exception\CouponNotValidException;
use App\Service\PaymentProcessor\Enum\PaymentStrategy;
use App\Service\PaymentProcessor\PaymentProcessorInterface;
use App\Service\Product\ProductInterface;
use App\Service\Tax\Exception\NotFoundException;
use App\Service\Tax\TaxInterface;
use JsonException;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/product', 'product.')]
class ProductController
{
    public function __construct(
        private readonly FormFactoryInterface $formFactory,
        private readonly DiscountInterface $discount,
        private readonly TaxInterface $tax,
        private readonly ProductInterface $product,
        private readonly PaymentProcessorInterface $paymentProcessor,
    ) {}

    /**
     * @throws CouponNotValidException
     * @throws NotFoundException
     * @throws ConstraintViolationHttpException
     * @throws \App\Service\Discount\Exception\NotFoundException
     */
    #[Route('/calculate-cost', name: 'calculate-cost', methods: [Request::METHOD_POST])]
    public function calculateCost(Request $request): Response
    {
        $requestDto = new CalculateProductCostRequest();

        // Very strange task for symfony/forms, why not Serializer::denormalize()?
        // $dto = $this->serializer->denormalize($request->getContent(), CalculateProductCostRequest::class);
        // $violations = $this->validator->validate($dto);
        $form = $this->formFactory->create(
            CalculateProductCostType::class,
            $requestDto,
            options: ['data_class' => CalculateProductCostRequest::class]
        );
        try {
            $requestData = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);
            $form->submit($requestData);
        } catch (JsonException) {
            throw new BadRequestHttpException('Invalid json format.');
        }

        $this->validateForm($form);

        $coupon = $requestDto->couponCode ? $this->discount->getCoupon($requestDto->couponCode) : null;
        $productPrice = $this->product->getProduct($requestDto->product)->price;
        $priceWithCoupon = $coupon?->getFixedPrice($productPrice) ?? $productPrice;
        $finallyPrice = $this->tax->getPriceWithTaxByNumber($priceWithCoupon, $requestDto->taxNumber);

        return new JsonResponse(new PaymentCostResponse($finallyPrice), Response::HTTP_OK);
    }

    /**
     * @throws ConstraintViolationHttpException
     */
    #[Route('/buy', name: 'buy', methods: [Request::METHOD_POST])]
    public function buyProduct(Request $request): Response
    {
        $requestDto = new BuyProductRequest();

        // Very strange task for symfony/forms, why not Serializer::denormalize()?
        $form = $this->formFactory->create(
            BuyProductType::class,
            $requestDto,
            options: ['data_class' => BuyProductRequest::class]
        );
        try {
            $requestData = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);
            $form->submit($requestData);
        } catch (JsonException) {
            throw new BadRequestHttpException('Invalid json format.');
        }

        $this->validateForm($form);

        $coupon = $requestDto->couponCode ? $this->discount->getCoupon($requestDto->couponCode) : null;
        $productPrice = $this->product->getProduct($requestDto->product)->price;
        $priceWithCoupon = $coupon?->getFixedPrice($productPrice) ?? $productPrice;
        $finallyPrice = $this->tax->getPriceWithTaxByNumber($priceWithCoupon, $requestDto->taxNumber);
        $this->paymentProcessor->processPayment(
            $finallyPrice,
            match ($requestDto->paymentProcessor) {
                PaymentProcessor::PayPal => PaymentStrategy::PayPal,
                PaymentProcessor::Stripe => PaymentStrategy::Stripe
            }
        );

        return new Response(null, Response::HTTP_OK);
    }

    /** @throws ConstraintViolationHttpException */
    private function validateForm(FormInterface $form): void
    {
        if ($form->isValid() === false) {
            /** @var list<FormError> $formErrors */
            $formErrors = $form->getErrors(true);
            $errors = [];
            foreach ($formErrors as $error) {
                $errors[$error->getOrigin()->getName()][] = $error->getMessage();
            }

            // Should be generated in ErrorHandler instead
            throw new ConstraintViolationHttpException($errors);
        }
    }
}
