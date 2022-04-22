<?php

/**
 * Criado por Diovanna Schell
 */

namespace App\Service;

use App\Entity\ItemPedido;
use App\Entity\Pedido;
use App\Exception\VinhoException;
use App\Repository\ItemPedidoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\HttpFoundation\Response;

class ItensPedidoService
{
    private ItemPedidoRepository $repository;

    public function __construct(EntityManagerInterface $entityManager, private VinhoService $vinhoService)
    {
        $this->repository = $entityManager->getRepository(ItemPedido::class);
    }

    /**
     * Cria um item de um pedido
     * 
     * @param array $itemPedido
     * @param Pedido $pedido
     * @param bool $flush
     * @return ItemPedido
     */
    public function create(array $itemPedido, Pedido $pedido, bool $flush = false): ItemPedido
    {
        $vinho = $this->vinhoService->findVinhoOrThrowException($itemPedido['vinhoId']);

        $item = new ItemPedido();
        $item->setQuantidade($itemPedido['quantidade'])
            ->setVinho($vinho)
            ->setPedido($pedido)
            ->setValorUnitario($vinho->getValor());

        try {
            $this->repository->add($item, $flush);
        } catch (Exception $e) {
            throw new VinhoException('Não foi possível salvar o item do pedido.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $item;
    }
}
