<?php

/**
 * Criado por Diovanna Schell
 */

namespace App\Service;

use App\Entity\Pedido;
use App\Exception\VinhoException;
use App\Repository\PedidoRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\HttpFoundation\Response;

class PedidoService
{
    private PedidoRepository $repository;

    public function __construct(EntityManagerInterface $entityManager, private FreteService $freteService, private ItensPedidoService $itensPedidoService)
    {
        $this->repository = $entityManager->getRepository(Pedido::class);
    }

    /**
     * Lista todos os pedidos feitos
     * 
     * @return Pedido[]
     */
    public function list(): array
    {
        return $this->repository->findAll();
    }

    /**
     * Cria um novo pedido e seus itens
     * 
     * @param array $dados
     * @return Pedido
     */
    public function create(array $dados): Pedido
    {
        $frete = $this->freteService->calcularFrete($dados['itensPedido'], $dados['distancia']);

        $pedido = new Pedido();
        $pedido->setData(new DateTime('now'))
            ->setValorFrete($frete);

        foreach ($dados['itensPedido'] as $itemPedido) {
            $item = $this->itensPedidoService->create($itemPedido, $pedido);
            $pedido->addItemPedido($item);
        }

        $valorItens = $this->calcularValorItens($pedido);

        $total = $frete + $valorItens;
        $pedido->setTotal($total);

        try {
            $this->repository->add($pedido);
        } catch (Exception $e) {
            throw new VinhoException('Ocorreu um erro ao inserir o pedido.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $pedido;
    }

    /**
     * Calcula o valor total do item para a quantidade selecionada.
     * 
     * @param Pedido $pedido
     * @return float
     */
    private function calcularValorItens(Pedido $pedido): float
    {
        $itensPedido = $pedido->getItemPedidos();
        $valor = 0;

        foreach ($itensPedido as $item) {
            $valor += $item->getValorUnitario() * $item->getQuantidade();
        }

        return $valor;
    }
}
