<?php

namespace App\Exceptions;

use Exception;

class VendaException extends Exception
{
    public function render($message)
    {
        return response($this->getMessage(), 500);
    }
}
