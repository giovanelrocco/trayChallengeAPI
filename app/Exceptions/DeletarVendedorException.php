<?php

namespace App\Exceptions;

use Exception;

class DeletarVendedorException extends Exception
{
    public function render($message)
    {
        return response($this->getMessage(), 500);
    }
}
