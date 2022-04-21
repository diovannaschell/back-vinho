<?php

/**
 * Criado por Diovanna Schell
 */

namespace App\Service;

use App\Entity\Produto;
use App\Exception\VinhoException;
use App\Repository\ProdutoRepository;
use App\Validator\ProdutoValidator;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\HttpFoundation\Response;

class ProdutoService
{
    private ProdutoRepository $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->repository = $entityManager->getRepository(Produto::class);
    }

    /**
     * Lista todos os produtos
     * 
     * @return Produtos[]
     */
    public function listProdutos(): array
    {
        return $this->repository->findAll();
    }

    /**
     * Cria um novo produto
     * 
     * @param array $dados
     * @return Produto
     */
    public function createProduto(array $dados): Produto
    {
        $produto = new Produto();
        $produto->setNome($dados['nome'])
            ->setPeso($dados['peso'])
            ->setTipo($dados['tipo'])
            ->setValor($dados['valor']);

        try {
            $this->repository->add($produto);
        } catch (Exception $e) {
            throw new VinhoException('Ocorreu um erro ao inserir o produto.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $produto;
    }

    /**
     * Atualiza o produto do id informado com os dados
     * 
     * @param int $id
     * @param array $dados
     * @return Produto
     */
    public function editProduto(int $id, array $dados): Produto
    {
        $produto = $this->repository->find($id);

        if (!$produto) {
            throw new VinhoException('O produto informado não existe.', Response::HTTP_NOT_FOUND);
        }

        $produto->setNome($dados['nome'])
            ->setPeso($dados['peso'])
            ->setTipo($dados['tipo'])
            ->setValor($dados['valor']);

        $this->repository->add($produto);

        return $produto;
    }

    /**
     * Deleta o produto que possui o id informado
     * 
     * @param int $id
     * @return void
     */
    public function deleteProduto(int $id): void
    {
        $produto = $this->repository->find($id);

        if (!$produto) {
            throw new VinhoException('O produto informado não existe.', Response::HTTP_NOT_FOUND);
        }

        try {
            $this->repository->remove($produto);
        } catch (Exception $e) {
            throw new VinhoException('Não foi possível deletar o produto.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Valida os campos da requisição com o validador de produtos
     * 
     * @param array $dados
     * @return void
     */
    public function validateProdutoRequest(array $dados): void
    {
        $validador = new ProdutoValidator();
        $erros = $validador->validate($dados);

        if (count($erros) > 0) {
            throw new VinhoException('Existem dados inválidos na requisição.', Response::HTTP_BAD_REQUEST);
        }
    }
}
