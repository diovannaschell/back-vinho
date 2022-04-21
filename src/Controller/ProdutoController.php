<?php

/**
 * Criado por Diovanna Schell
 */

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProdutoController
{
    /**
     * @Route("/produto", name="app_produto_list", methods={"GET"})
     */
    public function list(): Response
    {
        return new JsonResponse([], Response::HTTP_OK);
    }

    /**
     * @Route("/produto", name="app_produto_save", methods={"POST"})
     */
    public function save(Request $request): Response
    {
        $dados = $request->request->all();

        return new JsonResponse([], Response::HTTP_CREATED);
    }
}
