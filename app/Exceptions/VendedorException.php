<?php

namespace App\Exceptions;

use Exception;

class VendedorException extends Exception
{
    public function render($message)
    {
        return response($this->getMessage(), 500);
    }
}
