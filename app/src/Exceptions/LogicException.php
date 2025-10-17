<?php

namespace App\Exceptions;

use Symfony\Component\HttpFoundation\Response;

class LogicException extends \Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
