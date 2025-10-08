<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\ValueObject\CouponDiscount;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;

#[Entity()]
#[Table(name: 'coupon')]
class Coupon
{
    #[ORM\Id]
    #[ORM\Column(type: Types::INTEGER)]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private int $id;

    #[ORM\Column(type: Types::STRING, unique: true)]
    private string $code;

    #[ORM\Column(type: Types::STRING)]
    private string $name;

    #[ORM\Embedded(class: CouponDiscount::class)]
    private CouponDiscount $discount;

    public function __construct(
        string $code,
        string $name,
        CouponDiscount $discount,
    ) {
        $this->code = $code;
        $this->name = $name;
        $this->discount = $discount;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDiscount(): CouponDiscount
    {
        return $this->discount;
    }
}
