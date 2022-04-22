<?php

/**
 * Criado por Diovanna Schell
 */

namespace App\Controller;

use App\Service\FreteService;
use App\Service\PedidoService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class PedidoController extends AbstractController
{

    public function __construct(private PedidoService $pedidoService, private NormalizerInterface $normalizer)
    {
    }

    #[Route('/pedido', name: 'app_pedido_list', methods: ['GET'])]
    public function list(): Response
    {
        $pedidos = $this->pedidoService->listPedidos();
        $pedidosNormalizados = $this->normalizer->normalize($pedidos, null, ['groups' => 'pedido']);

        return new JsonResponse($pedidosNormalizados, Response::HTTP_OK);
    }

    #[Route('/pedido', name: 'app_pedido_create', methods: ['POST'])]
    public function create(Request $request): Response
    {
        $dados = $request->request->all();
        $this->pedidoService->validatePedidoRequest($dados);

        $pedido = $this->pedidoService->createPedido($dados);
        $pedidoNormalizado = $this->normalizer->normalize($pedido, null, ['groups' => 'pedido']);

        return new JsonResponse($pedidoNormalizado, Response::HTTP_CREATED);
    }

    #[Route('/pedido/calcular-frete', name: 'app_pedido_frete', methods: ['GET'])]
    public function calcularFrete(Request $request, FreteService $freteService)
    {
        $dados = $request->request->all();
        $this->pedidoService->validatePedidoRequest($dados);

        $frete = $freteService->calcularFrete($dados['itensPedido'], $dados['distancia']);

        return new JsonResponse(['frete' => $frete], Response::HTTP_OK);
    }
}
