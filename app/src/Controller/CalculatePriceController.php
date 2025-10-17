<?php

declare(strict_types=1);

namespace App\Controller;

use App\DTO\CalculationPriceRequestDto;
use App\Exceptions\CountryNotFoundException;
use App\Exceptions\LogicException;
use App\Exceptions\ProductNotFoundException;
use App\Service\CalculationPriceService;
use App\View\CalculateResultView;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class CalculatePriceController extends BaseController
{
    public function __construct(
        private ValidatorInterface $validator,
        private CalculationPriceService  $calculationPriceService
    ) {
    }

    #[Route('/calculate-price', name: 'calculate_price', methods: ['POST'])]
    public function __invoke(CalculationPriceRequestDto $calculationPriceRequestDto): JsonResponse
    {
        $errors = $this->validator->validate($calculationPriceRequestDto);

        if (count($errors) > 0) {
            return $this->createResponseBadRequest($errors);
        }

        try {
            $calculatedPrice = $this->calculationPriceService->calculatePrice($calculationPriceRequestDto);
        } catch (ProductNotFoundException $productNotFoundException) {
            return $this->createResponseBadRequest($productNotFoundException);
        } catch (CountryNotFoundException $countryNotFoundException) {
            return $this->createResponseBadRequest($countryNotFoundException);
        } catch (LogicException $logicException) {
            return $this->createHttpUnprocessableEntity($logicException);
        }

        $view = new CalculateResultView($calculatedPrice);

        return $this->createResponseSuccess($view->getData());
    }
}
