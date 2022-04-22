<?php

/**
 * Criado por Diovanna Schell
 */

namespace App\Service;

use App\Entity\ItemPedido;
use App\Entity\Pedido;
use App\Entity\Vinho;
use App\Exception\VinhoException;
use App\Repository\ItemPedidoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\HttpFoundation\Response;

class ItensPedidoService
{
    private EntityManagerInterface $entityManager;

    private ItemPedidoRepository $repository;

    private VinhoService $vinhoService;

    public function __construct(EntityManagerInterface $entityManager, VinhoService $vinhoService)
    {
        $this->entityManager = $entityManager;
        $this->vinhoService = $vinhoService;
        $this->repository = $entityManager->getRepository(ItemPedido::class);
    }

    /**
     * Cria um item de um pedido
     * 
     * @param array $itensPedido
     * @param Pedido $pedido
     * @return void
     */
    public function createItensPedido(array $itensPedido, Pedido $pedido): void
    {
        foreach ($itensPedido as $itemPedido) {
            $vinho = $this->vinhoService->findVinhoOrThrowException($itemPedido['vinhoId']);

            $item = new ItemPedido();
            $item->setQuantidade($itemPedido['quantidade'])
                ->setVinho($vinho)
                ->setPedido($pedido)
                ->setValorUnitario($vinho->getValor());

            try {
                $this->repository->add($item, false);
            } catch (Exception $e) {
                throw new VinhoException('Não foi possível salvar o item do pedido.', Response::HTTP_INTERNAL_SERVER_ERROR);
            }

            $pedido->addItemPedido($item);
        }
    }

    /**
     * Calcula o valor total do item para a quantidade selecionada.
     * 
     * @param Pedido $pedido
     * @return float
     */
    public function calcularValorItens(Pedido $pedido): float
    {
        $itensPedido = $pedido->getItemPedidos();
        $valor = 0;

        foreach ($itensPedido as $item) {
            $valor += $item->getValorUnitario() * $item->getQuantidade();
        }

        return $valor;
    }
}
