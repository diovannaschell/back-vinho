<?php

/**
 * Criado por Diovanna Schell
 */

namespace App\Controller;

use App\Service\ProdutoService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class ProdutoController extends AbstractController
{
    private ProdutoService $produtoService;

    private NormalizerInterface $normalizer;

    public function __construct(ProdutoService $produtoService, NormalizerInterface $normalizer)
    {
        $this->produtoService = $produtoService;
        $this->normalizer = $normalizer;
    }

    #[Route('/produto', name: 'app_produto_list', methods: ['GET'])]
    public function list(): Response
    {
        $produtos = $this->produtoService->listProdutos();
        $produtosNormalizados = $this->normalizer->normalize($produtos);

        return new JsonResponse($produtosNormalizados, Response::HTTP_OK);
    }

    #[Route('/produto', name: 'app_produto_create', methods: ['POST'])]
    public function create(Request $request): Response
    {
        $dados = $request->request->all();
        $this->produtoService->validateProdutoRequest($dados);

        $produto = $this->produtoService->createProduto($dados);
        $produtoNormalizado = $this->normalizer->normalize($produto);

        return new JsonResponse($produtoNormalizado, Response::HTTP_CREATED);
    }

    #[Route('/produto/{id}', name: 'app_produto_edit', methods: ['PUT'])]
    public function edit(Request $request, $id): Response
    {
        $dados = $request->request->all();
        $this->produtoService->validateProdutoRequest($dados);

        $produto = $this->produtoService->editProduto($id, $dados);
        $produtoNormalizado = $this->normalizer->normalize($produto);

        return new JsonResponse($produtoNormalizado, Response::HTTP_OK);
    }

    #[Route('/produto/{id}', name: 'app_produto_delete', methods: ['DELETE'])]
    public function delete($id): Response
    {
        $this->produtoService->deleteProduto($id);

        return new JsonResponse([], Response::HTTP_NO_CONTENT);
    }
}
