<?php

namespace App\Exceptions;

use Symfony\Component\HttpFoundation\Response;

class PaymentFailedException extends \Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message, Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
