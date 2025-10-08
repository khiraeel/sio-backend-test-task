<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class ProductRepository
{
    private EntityRepository $repo;

    public function __construct(private EntityManagerInterface $entityManager)
    {
        $this->repo = $this->entityManager->getRepository(Product::class);
    }

    public function findAll(): array
    {
        return $this->repo->findAll();
    }
}
