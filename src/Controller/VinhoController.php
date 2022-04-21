<?php

/**
 * Criado por Diovanna Schell
 */

namespace App\Controller;

use App\Service\VinhoService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class VinhoController extends AbstractController
{
    private VinhoService $vinhoService;

    private NormalizerInterface $normalizer;

    public function __construct(VinhoService $vinhoService, NormalizerInterface $normalizer)
    {
        $this->vinhoService = $vinhoService;
        $this->normalizer = $normalizer;
    }

    #[Route('/vinho', name: 'app_vinho_list', methods: ['GET'])]
    public function list(): Response
    {
        $vinhos = $this->vinhoService->listVinhos();
        $vinhosNormalizados = $this->normalizer->normalize($vinhos);

        return new JsonResponse($vinhosNormalizados, Response::HTTP_OK);
    }

    #[Route('/vinho', name: 'app_vinho_create', methods: ['POST'])]
    public function create(Request $request): Response
    {
        $dados = $request->request->all();
        $this->vinhoService->validateVinhoRequest($dados);

        $vinho = $this->vinhoService->createVinho($dados);
        $vinhoNormalizado = $this->normalizer->normalize($vinho);

        return new JsonResponse($vinhoNormalizado, Response::HTTP_CREATED);
    }

    #[Route('/vinho/{id}', name: 'app_vinho_edit', methods: ['PUT'])]
    public function edit(Request $request, $id): Response
    {
        $dados = $request->request->all();
        $this->vinhoService->validateVinhoRequest($dados);

        $vinho = $this->vinhoService->editVinho($id, $dados);
        $vinhoNormalizado = $this->normalizer->normalize($vinho);

        return new JsonResponse($vinhoNormalizado, Response::HTTP_OK);
    }

    #[Route('/vinho/{id}', name: 'app_vinho_delete', methods: ['DELETE'])]
    public function delete($id): Response
    {
        $this->vinhoService->deleteVinho($id);

        return new JsonResponse([], Response::HTTP_NO_CONTENT);
    }
}
