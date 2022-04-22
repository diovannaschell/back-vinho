<?php

/**
 * Criado por Diovanna Schell
 */

namespace App\Service;

use App\Entity\Vinho;
use Doctrine\ORM\EntityManagerInterface;

class FreteService
{
    public function __construct(private VinhoService $vinhoService)
    {
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
