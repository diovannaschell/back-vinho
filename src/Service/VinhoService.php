<?php

/**
 * Criado por Diovanna Schell
 */

namespace App\Service;

use App\Entity\Pedido;
use App\Entity\Vinho;
use App\Exception\VinhoException;
use App\Repository\PedidoRepository;
use App\Repository\VinhoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\HttpFoundation\Response;

class VinhoService
{
    private VinhoRepository $repository;

    private PedidoRepository $pedidoRepository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->repository = $entityManager->getRepository(Vinho::class);
        $this->pedidoRepository = $entityManager->getRepository(Pedido::class);
    }

    /**
     * Lista todos os vinhos
     * 
     * @return Vinho[]
     */
    public function list(): array
    {
        return $this->repository->findAll();
    }

    /**
     * Cria um novo vinho
     * 
     * @param array $dados
     * @return Vinho
     */
    public function create(array $dados): Vinho
    {
        $vinho = new Vinho();
        $vinho->setNome($dados['nome'])
            ->setPeso($dados['peso'])
            ->setTipo($dados['tipo'])
            ->setValor($dados['valor']);

        try {
            $this->repository->add($vinho);
        } catch (Exception $e) {
            throw new VinhoException('Ocorreu um erro ao inserir o vinho.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $vinho;
    }

    /**
     * Atualiza o vinho do id informado com os dados
     * 
     * @param int $id
     * @param array $dados
     * @return Vinho
     */
    public function edit(int $id, array $dados): Vinho
    {
        $vinho = $this->findVinhoOrThrowException($id);

        $vinho->setNome($dados['nome'])
            ->setPeso($dados['peso'])
            ->setTipo($dados['tipo'])
            ->setValor($dados['valor']);

        $this->repository->add($vinho);

        return $vinho;
    }

    /**
     * Deleta o vinho que possui o id informado
     * 
     * @param int $id
     * @return void
     */
    public function delete(int $id): void
    {
        $vinho = $this->findVinhoOrThrowException($id);

        $pedidos = $this->pedidoRepository->findByVinho($vinho);
        if (count($pedidos) > 0) {
            throw new VinhoException('Não é possível deletar o vinho pois já existem pedidos vinculados a ele.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        try {
            $this->repository->remove($vinho);
        } catch (Exception $e) {
            throw new VinhoException('Não foi possível deletar o vinho.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Busca um vinho pelo id e se não encontrar dá uma exception.
     * 
     * @param int $id
     * @return Vinho
     * @throws VinhoException
     */
    public function findVinhoOrThrowException(int $id): Vinho
    {
        $vinho = $this->repository->find($id);

        if (!$vinho) {
            throw new VinhoException('O vinho informado não existe.', Response::HTTP_NOT_FOUND);
        }

        return $vinho;
    }
}
