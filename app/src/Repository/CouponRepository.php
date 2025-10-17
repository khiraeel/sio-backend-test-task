<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Coupon;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class CouponRepository
{
    private EntityRepository $repo;

    public function __construct(private EntityManagerInterface $entityManager)
    {
        $this->repo = $this->entityManager->getRepository(Coupon::class);
    }

    public function getByCode(string $code): ?Coupon
    {
        return $this->repo->findOneBy(['code' => $code]);
    }

    public function findAll(): array
    {
        return $this->repo->findAll();
    }
}
