<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Product;
use App\Entity\ValueObject\Price;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $products = [
            ['name' => 'iPhone', 'price' => Price::eur(10000)],
            ['name' => 'Headphones', 'price' => Price::eur(2000)],
            ['name' => 'Case', 'price' => Price::eur(1000)],
        ];

        foreach ($products as $data) {
            $product = new Product(
                $data['name'],
                $data['price']
            );
            //dump($product);
            $manager->persist($product);
        }

        $manager->flush();
    }
}
