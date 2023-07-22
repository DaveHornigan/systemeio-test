<?php

namespace App\Service\Tax\Exception;

use Exception;

class NotFoundException extends Exception
{
    protected $code = 404;
}
