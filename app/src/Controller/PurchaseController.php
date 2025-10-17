<?php

declare(strict_types=1);

namespace App\Controller;

use App\DTO\PurchaseRequestDto;
use App\Exceptions\CountryNotFoundException;
use App\Exceptions\LogicException;
use App\Exceptions\PaymentFailedException;
use App\Exceptions\ProductNotFoundException;
use App\Service\PurchaseService;
use App\View\PurchaseResultView;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class PurchaseController extends BaseController
{
    public function __construct(
        private ValidatorInterface $validator,
        private PurchaseService $purchaseService,
    ) {
    }

    #[Route('/purchase', name: 'purchase', methods: ['POST'])]
    public function __invoke(PurchaseRequestDto $purchaseRequestDto): JsonResponse
    {
        $errors = $this->validator->validate($purchaseRequestDto);

        if (count($errors) > 0) {
            return $this->createResponseBadRequest($errors);
        }

        try {
            $this->purchaseService->makePurchase($purchaseRequestDto);
        } catch (ProductNotFoundException $productNotFoundException) {
            return $this->createResponseBadRequest($productNotFoundException);
        } catch (CountryNotFoundException $countryNotFoundException) {
            return $this->createResponseBadRequest($countryNotFoundException);
        } catch (LogicException $logicException) {
            return $this->createHttpUnprocessableEntity($logicException);
        } catch (PaymentFailedException $paymentFailedException) {
            dd($paymentFailedException);
            return $this->createResponseBadRequest($paymentFailedException);
        }

        $view = new PurchaseResultView();

        return $this->createResponseSuccess($view->getData());
    }
}
