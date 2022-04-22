<?php

/**
 * Criado por Diovanna Schell
 */

namespace App\Validator;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validation;

class PedidoValidator
{
    public function validate(array $input): ConstraintViolationList
    {
        $validator = Validation::createValidator();

        $constraints = new Assert\Collection([
            'distancia' => [
                new Assert\Type(['type' => 'numeric']),
                new Assert\GreaterThan(0),
            ],
            'itensPedido' => [
                new Assert\Count(['min' => 1]),
                new Assert\All([
                    new Assert\Collection([
                        'vinhoId' => [
                            new Assert\Type(['type' => 'int']),
                            new Assert\NotBlank()
                        ],
                        'quantidade' => [
                            new Assert\Type(['type' => 'int']),
                            new Assert\GreaterThan(0),
                        ],
                    ])
                ]),
            ]
        ]);

        $violations = $validator->validate($input, $constraints, null);

        return $violations;
    }
}
