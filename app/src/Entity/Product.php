<?php

namespace App\Entity;

use App\Entity\ValueObject\Price;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;

#[Entity()]
#[Table(name: 'product')]
class Product
{
    #[ORM\Id]
    #[ORM\Column(type: Types::INTEGER)]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private int $id;

    #[ORM\Column(type: Types::STRING)]
    private string $name;

    #[ORM\Column(type: Types::STRING)]
    private Price $price;

    public function __construct(
        string $name,
        Price $price
    ) {
        $this->name = $name;
        $this->price = $price;
    }
}
