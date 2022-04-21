<?php

/**
 * Criado por Diovanna Schell
 */

namespace App\Service;

use App\Entity\Vinho;
use App\Exception\VinhoException;
use App\Repository\VinhoRepository;
use App\Validator\VinhoValidator;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\HttpFoundation\Response;

class VinhoService
{
    private VinhoRepository $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->repository = $entityManager->getRepository(Vinho::class);
    }

    /**
     * Lista todos os vinhos
     * 
     * @return Vinhos[]
     */
    public function listVinhos(): array
    {
        return $this->repository->findAll();
    }

    /**
     * Cria um novo vinho
     * 
     * @param array $dados
     * @return Vinho
     */
    public function createVinho(array $dados): Vinho
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
    public function editVinho(int $id, array $dados): Vinho
    {
        $vinho = $this->repository->find($id);

        if (!$vinho) {
            throw new VinhoException('O vinho informado não existe.', Response::HTTP_NOT_FOUND);
        }

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
    public function deleteVinho(int $id): void
    {
        $vinho = $this->repository->find($id);

        if (!$vinho) {
            throw new VinhoException('O vinho informado não existe.', Response::HTTP_NOT_FOUND);
        }

        try {
            $this->repository->remove($vinho);
        } catch (Exception $e) {
            throw new VinhoException('Não foi possível deletar o vinho.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Valida os campos da requisição com o validador de vinhos
     * 
     * @param array $dados
     * @return void
     */
    public function validateVinhoRequest(array $dados): void
    {
        $validador = new VinhoValidator();
        $erros = $validador->validate($dados);

        if (count($erros) > 0) {
            throw new VinhoException('Existem dados inválidos na requisição.', Response::HTTP_BAD_REQUEST);
        }
    }
}
