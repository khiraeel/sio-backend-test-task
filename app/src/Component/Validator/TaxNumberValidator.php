<?php

declare(strict_types=1);

namespace App\Component\Validator;

use App\Enum\CountryEnum;
use App\Service\TaxNumberParseService;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class TaxNumberValidator extends ConstraintValidator
{
    public function __construct(
        private TaxNumberParseService $taxNumberParseService
    ) {
    }
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof TaxNumber) {
            return;
        }

        if (!is_string($value) || strlen($value) < 2) {
            $this->context->buildViolation('Tax number must be a valid string.')
                ->addViolation();
            return;
        }

        $country = $this->taxNumberParseService->getCountryCode($value);
        $patterns = [
            CountryEnum::GERMANY->value => '/^DE\d{9}$/',
            CountryEnum::ITALY->value => '/^IT\d{11}$/',
            CountryEnum::GREECE->value => '/^GR\d{9}$/',
            CountryEnum::FRANCE->value => '/^FR[A-Z]{2}\d{9}$/',
        ];

        if (!isset($patterns[$country]) || !preg_match($patterns[$country], $value)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ country }}', $country)
                ->addViolation();
        }
    }
}
