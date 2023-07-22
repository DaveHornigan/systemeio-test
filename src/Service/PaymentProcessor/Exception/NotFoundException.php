<?php

namespace App\Service\PaymentProcessor\Exception;

use Exception;

class NotFoundException extends Exception
{
    protected $code = 404;
}
