<?php

namespace App\Service\Product\Exception;

use Exception;

class NotFoundException extends Exception
{
    protected $code = 404;
}
