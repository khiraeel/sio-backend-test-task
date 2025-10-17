<?php

namespace App\Exceptions;

use Symfony\Component\HttpFoundation\Response;

class ProductNotFoundException extends \Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message, Response::HTTP_BAD_REQUEST);
    }
}
