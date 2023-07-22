<?php

namespace App\Form\Type;

use App\Enum\PaymentProcessor;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class CalculateProductCostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('product', TextType::class, ['required' => true])
            ->add('taxNumber', TextType::class, ['required' => true])
            ->add('couponCode', TextType::class, ['required' => false])
            ->add('paymentProcessor', EnumType::class, [
                'required' => false, // Not required for cost calculation... Why this is in the body of the request is not clear.
                'class' => PaymentProcessor::class
            ])
        ;
    }
}
