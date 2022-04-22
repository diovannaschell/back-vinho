<?php

namespace App\Tests\Service;

use App\Entity\Vinho;
use App\Service\FreteService;
use App\Service\VinhoService;
use PHPUnit\Framework\TestCase;

class FreteServiceTest extends TestCase
{
    private FreteService $freteService;

    public function setUp(): void
    {
        $vinho = new Vinho();
        $vinho->setId(1)
            ->setNome('vinho de teste')
            ->setTipo('doce')
            ->setPeso(1.8)
            ->setValor(17);

        // criar mock do service de vinho
        $vinhoService = $this->createMock(VinhoService::class);
        $vinhoService->expects($this->any())
            ->method('findVinhoOrThrowException')
            ->willReturn($vinho);

        $this->freteService = new FreteService($vinhoService);
    }

    public function testDeveCalcularFreteComDistanciaMenor100km()
    {
        $frete = $this->freteService->calcularFrete(
            [
                ['vinhoId' => 1, 'quantidade' => 2],
            ],
            80
        );

        $this->assertEquals(18, $frete);
    }

    public function testDeveCalcularFreteComDistanciaMaior100km()
    {
        $frete = $this->freteService->calcularFrete(
            [
                ['vinhoId' => 1, 'quantidade' => 2],
            ],
            150
        );

        $this->assertEquals(27, $frete);
    }
}
