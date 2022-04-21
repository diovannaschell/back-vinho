<?php

namespace App\Tests\Validator;

use App\Entity\Vinho;
use App\Service\FreteService;
use Doctrine\Persistence\ObjectRepository;
use PHPUnit\Framework\TestCase;
use Doctrine\ORM\EntityManager;

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

        // criar o mock do repositorio
        $vinhoRepository = $this->createMock(ObjectRepository::class);
        $vinhoRepository->expects($this->any())
            ->method('find')
            ->willReturn($vinho);

        // criar mock do entity manager
        $objectManager = $this->createMock(EntityManager::class);
        $objectManager->expects($this->any())
            ->method('getRepository')
            ->willReturn($vinhoRepository);

        $this->freteService = new FreteService($objectManager);
    }

    public function testDeveCalcularFreteComDistanciaMenor100km()
    {
        $frete = $this->freteService->calcularFrete(
            [['id' => 1, 'quantidade' => 2]],
            80
        );

        $this->assertEquals(18, $frete);
    }

    public function testDeveCalcularFreteComDistanciaMaior100km()
    {
        $frete = $this->freteService->calcularFrete(
            [['id' => 1, 'quantidade' => 2]],
            150
        );

        $this->assertEquals(27, $frete);
    }
}
