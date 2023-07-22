<?php

namespace App\Service\Discount\Exception;

use Exception;

class NotFoundException extends Exception
{
    protected $code = 404;
}
