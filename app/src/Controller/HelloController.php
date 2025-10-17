<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\CouponRepository;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class HelloController extends BaseController
{
    public function __construct(
        private ProductRepository $productRepository,
        private CouponRepository $couponRepository,
    ) {
    }

    #[Route('/products', name: 'products', methods: ['GET'])]
    public function products(): JsonResponse
    {
        $productList = $this->productRepository->findAll();
        $arView = [];
        foreach ($productList as $product) {
            $arView[] = [
                'id' => $product->getId(),
                'name' => $product->getName(),
                'price' => $product->getPrice()->getAmount(),
            ];
        }

        return new JsonResponse($arView);
    }

    #[Route('/coupons', name: 'coupons', methods: ['GET'])]
    public function coupons(): JsonResponse
    {
        $list = $this->couponRepository->findAll();
        $arView = [];
        foreach ($list as $item) {
            $arView[] = [
                'id' => $item->getId(),
                'code' => $item->getCode(),
                'name' => $item->getName(),
                'discount_type' => $item->getDiscount()->getType(),
                'discount' => $item->getDiscount()->getValue(),
            ];
        }

        return new JsonResponse($arView);
    }
}
