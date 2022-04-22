<?php

/**
 * Criado por Diovanna Schell
 */

namespace App\Service;

use App\Entity\Pedido;
use App\Exception\VinhoException;
use App\Repository\PedidoRepository;
use App\Validator\PedidoValidator;
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
    public function listPedidos(): array
    {
        return $this->repository->findAll();
    }

    /**
     * Cria um novo pedido e seus itens
     * 
     * @param array $dados
     * @return Pedido
     */
    public function createPedido(array $dados): Pedido
    {
        $frete = $this->freteService->calcularFrete($dados['itensPedido'], $dados['distancia']);

        $pedido = new Pedido();
        $pedido->setData(new DateTime('now'))
            ->setValorFrete($frete);

        $this->itensPedidoService->createItensPedido($dados['itensPedido'], $pedido);
        $valorItens = $this->itensPedidoService->calcularValorItens($pedido);

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
     * Valida os campos da requisição com o validador de pedidos
     * 
     * @param array $dados
     * @return void
     */
    public function validatePedidoRequest(array $dados): void
    {
        $validador = new PedidoValidator();
        $erros = $validador->validate($dados);

        if (count($erros) > 0) {
            throw new VinhoException('Existem dados inválidos na requisição.', Response::HTTP_BAD_REQUEST);
        }
    }
}
