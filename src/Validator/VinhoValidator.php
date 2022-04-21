<?php

/**
 * Criado por Diovanna Schell
 */

namespace App\Validator;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validation;

class VinhoValidator
{
    public function validate(array $input): ConstraintViolationList
    {
        $validator = Validation::createValidator();

        $constraints = new Assert\Collection([
            'nome' => new Assert\NotBlank(),
            'tipo' => new Assert\NotBlank(),
            'peso' => [
                new Assert\Type(['type' => 'numeric']),
                new Assert\GreaterThan(0),
            ],
            'valor' => [
                new Assert\Type(['type' => 'numeric']),
                new Assert\GreaterThan(0),
            ],
        ]);

        $violations = $validator->validate($input, $constraints, null);

        return $violations;
    }
}
