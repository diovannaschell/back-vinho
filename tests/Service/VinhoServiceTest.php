<?php

namespace App\Tests\Service;

use App\Entity\Vinho;
use App\Exception\VinhoException;
use App\Repository\VinhoRepository;
use App\Service\VinhoService;
use PHPUnit\Framework\TestCase;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Response;

class VinhoServiceTest extends TestCase
{

    public function testDeveRetornarVinhoQuandoExistir()
    {
        $vinho = new Vinho();
        $vinho->setId(1)
            ->setNome('vinho de teste')
            ->setTipo('doce')
            ->setPeso(1.8)
            ->setValor(17);

        // criar o mock do repositorio
        $vinhoRepository = $this->createMock(VinhoRepository::class);
        $vinhoRepository->expects($this->any())
            ->method('find')
            ->willReturn($vinho);

        // criar mock do entity manager
        $entityManager = $this->createMock(EntityManager::class);
        $entityManager->expects($this->any())
            ->method('getRepository')
            ->willReturn($vinhoRepository);

        $vinhoService = new VinhoService($entityManager);
        $vinhoRetornado = $vinhoService->findVinhoOrThrowException(1);

        $this->assertSame($vinho, $vinhoRetornado);
    }

    public function testDeveDarExcessaoQuandoNaoTiverVinho()
    {
        $this->expectException(VinhoException::class);
        $this->expectExceptionMessage('O vinho informado não existe.');
        $this->expectExceptionCode(Response::HTTP_NOT_FOUND);

        // criar o mock do repositorio
        $vinhoRepository = $this->createMock(VinhoRepository::class);
        $vinhoRepository->expects($this->any())
            ->method('find')
            ->willReturn(null);

        // criar mock do entity manager
        $entityManager = $this->createMock(EntityManager::class);
        $entityManager->expects($this->any())
            ->method('getRepository')
            ->willReturn($vinhoRepository);

        $vinhoService = new VinhoService($entityManager);
        $vinhoRetornado = $vinhoService->findVinhoOrThrowException(1);
    }
}
