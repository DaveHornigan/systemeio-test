<?php

namespace App\Service\PaymentProcessor\Exception;

class PaymentException extends \Exception
{
    protected $message = 'An error occurred while processing the payment';
}
