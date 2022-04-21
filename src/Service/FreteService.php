<?php

/**
 * Criado por Diovanna Schell
 */

namespace App\Service;

use App\Entity\Vinho;
use Doctrine\ORM\EntityManagerInterface;

class FreteService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Calcula o valor do frete com base nos vinhos selecionados e distância informada
     * 
     * @param array $vinhosSelecionados
     * @param float $distancia
     */
    public function calcularFrete(array $vinhosSelecionados, float $distancia): float
    {
        $pesoProdutos = 0;

        foreach ($vinhosSelecionados as $vinhoSelecionado) {
            $vinho = $this->entityManager->getRepository(Vinho::class)->find($vinhoSelecionado['id']);
            $pesoProdutos += $vinho->getPeso() * $vinhoSelecionado['quantidade'];
        }

        $valor = $pesoProdutos * 5;

        if ($distancia > 100) {
            $valor = $valor * $distancia / 100;
        }

        return $valor;
    }
}
