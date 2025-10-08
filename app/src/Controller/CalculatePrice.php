<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class CalculatePrice extends BaseController
{
    public function __construct() {
    }

    #[Route('/calculate-price', name: 'calculate_price', methods: ['POST'])]
    public function __invoke(): JsonResponse
    {
    }
}
