<?php

/**
 * Criado por Diovanna Schell
 */

namespace App\Controller;

use App\Exception\VinhoException;
use App\Service\VinhoService;
use App\Validator\VinhoValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class VinhoController extends AbstractController
{
    public function __construct(private VinhoService $vinhoService, private NormalizerInterface $normalizer)
    {
    }

    #[Route('/vinho', name: 'app_vinho_list', methods: ['GET'])]
    public function list(): Response
    {
        $vinhos = $this->vinhoService->list();
        $vinhosNormalizados = $this->normalizer->normalize($vinhos);

        return new JsonResponse($vinhosNormalizados, Response::HTTP_OK);
    }

    #[Route('/vinho', name: 'app_vinho_create', methods: ['POST'])]
    public function create(Request $request): Response
    {
        $dados = $request->request->all();
        $this->validateVinhoRequest($dados);

        $vinho = $this->vinhoService->create($dados);
        $vinhoNormalizado = $this->normalizer->normalize($vinho);

        return new JsonResponse($vinhoNormalizado, Response::HTTP_CREATED);
    }

    #[Route('/vinho/{id}', name: 'app_vinho_edit', methods: ['PUT'])]
    public function edit(Request $request, $id): Response
    {
        $dados = $request->request->all();
        $this->validateVinhoRequest($dados);

        $vinho = $this->vinhoService->edit($id, $dados);
        $vinhoNormalizado = $this->normalizer->normalize($vinho);

        return new JsonResponse($vinhoNormalizado, Response::HTTP_OK);
    }

    #[Route('/vinho/{id}', name: 'app_vinho_delete', methods: ['DELETE'])]
    public function delete($id): Response
    {
        $this->vinhoService->delete($id);

        return new JsonResponse([], Response::HTTP_NO_CONTENT);
    }

    /**
     * Valida os campos da requisição com o validador de vinhos
     * 
     * @param array $dados
     * @return void
     */
    private function validateVinhoRequest(array $dados): void
    {
        $validador = new VinhoValidator();
        $erros = $validador->validate($dados);

        if (count($erros) > 0) {
            throw new VinhoException('Existem dados inválidos na requisição.', Response::HTTP_BAD_REQUEST);
        }
    }
}
