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

    private VinhoService $vinhoService;

    public function __construct(EntityManagerInterface $entityManager, VinhoService $vinhoService)
    {
        $this->entityManager = $entityManager;
        $this->vinhoService = $vinhoService;
    }

    /**
     * Calcula o valor do frete com base nos vinhos selecionados e distância informada
     * 
     * @param array $itensPedido
     * @param float $distancia
     */
    public function calcularFrete(array $itensPedido, float $distancia): float
    {
        $pesoProdutos = 0;

        foreach ($itensPedido as $item) {
            $vinho = $this->vinhoService->findVinhoOrThrowException($item['vinhoId']);
            $pesoProdutos += $vinho->getPeso() * $item['quantidade'];
        }

        $valor = $pesoProdutos * 5;

        if ($distancia > 100) {
            $valor = $valor * $distancia / 100;
        }

        return $valor;
    }
}
