<?php

namespace App\Exceptions;

use Symfony\Component\HttpFoundation\Response;

class CountryNotFoundException extends \Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message, Response::HTTP_BAD_REQUEST);
    }
}
