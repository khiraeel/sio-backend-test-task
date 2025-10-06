<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;


class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $products = [
            ['name' => 'iPhone', 'price' => 100.00],
            ['name' => 'Headphones', 'price' => 20.00],
            ['name' => 'Case', 'price' => 10.00],
        ];

        foreach ($products as $data) {
            $product = new Product(
                $data['name'],
                $data['price']
            );
            $manager->persist($product);
        }

        $manager->flush();
    }
}
