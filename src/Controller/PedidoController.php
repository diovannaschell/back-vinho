<?php

/**
 * Criado por Diovanna Schell
 */

namespace App\Controller;

use App\Exception\VinhoException;
use App\Service\FreteService;
use App\Service\PedidoService;
use App\Validator\PedidoValidator;
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

    #[Route('/pedidos', name: 'app_pedido_list', methods: ['GET'])]
    public function list(): Response
    {
        $pedidos = $this->pedidoService->list();
        $pedidosNormalizados = $this->normalizer->normalize($pedidos, null, ['groups' => 'pedido']);

        return new JsonResponse($pedidosNormalizados, Response::HTTP_OK);
    }

    #[Route('/pedidos', name: 'app_pedido_create', methods: ['POST'])]
    public function create(Request $request): Response
    {
        $dados = $request->request->all();
        $this->validatePedidoRequest($dados);

        $pedido = $this->pedidoService->create($dados);
        $pedidoNormalizado = $this->normalizer->normalize($pedido, null, ['groups' => 'pedido']);

        return new JsonResponse($pedidoNormalizado, Response::HTTP_CREATED);
    }

    #[Route('/pedidos/calcular-frete', name: 'app_pedido_frete', methods: ['GET'])]
    public function calcularFrete(Request $request, FreteService $freteService)
    {
        $distancia = $request->query->get('distancia');
        $itensPedido = json_decode($request->query->get('itensPedido'), true);

        $this->validatePedidoRequest(['distancia' => $distancia, 'itensPedido' => $itensPedido]);

        $frete = $freteService->calcularFrete($itensPedido, $distancia);

        return new JsonResponse(['frete' => $frete], Response::HTTP_OK);
    }

    /**
     * Valida os campos da requisição com o validador de pedidos
     * 
     * @param array $dados
     * @return void
     */
    private function validatePedidoRequest(array $dados): void
    {
        $validador = new PedidoValidator();
        $erros = $validador->validate($dados);

        if (count($erros) > 0) {
            throw new VinhoException('Existem dados inválidos na requisição.', Response::HTTP_BAD_REQUEST);
        }
    }
}
