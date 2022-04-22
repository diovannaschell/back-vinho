<?php

namespace App\Tests\Validator;

use App\Validator\PedidoValidator;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PedidoValidatorTest extends WebTestCase
{
    private array $data;

    public PedidoValidator $validator;

    public function setUp(): void
    {
        $this->validator = new PedidoValidator();

        $this->data = [
            'distancia' => 80,
            'itensPedido' => [
                [
                    'vinhoId' => 1,
                    'quantidade' => 5,
                ],
            ],
        ];
    }

    public function testNaoDeveRetornarErroComDadosValidos()
    {
        $erros = $this->validator->validate($this->data);
        $this->assertCount(0, $erros);
    }

    public function testDeveRetornarErroSemItens()
    {
        unset($this->data['itensPedido']);
        $erros = $this->validator->validate($this->data);
        $this->assertGreaterThan(0, count($erros));

        $this->data['itensPedido'] = [];
        $erros = $this->validator->validate($this->data);
        $this->assertGreaterThan(0, count($erros));
    }

    public function testDeveRetornarErroVinhoIdInvalido()
    {
        unset($this->data['itensPedido'][0]['vinhoId']);
        $erros = $this->validator->validate($this->data);
        $this->assertGreaterThan(0, count($erros));

        $this->data['itensPedido']['vinhoId'] = 0;
        $erros = $this->validator->validate($this->data);
        $this->assertGreaterThan(0, count($erros));

        $this->data['itensPedido']['vinhoId'] = 'a';
        $erros = $this->validator->validate($this->data);
        $this->assertGreaterThan(0, count($erros));
    }

    public function testDeveRetornarErroQuantidadeInvalida()
    {
        unset($this->data['itensPedido'][0]['quantidade']);
        $erros = $this->validator->validate($this->data);
        $this->assertGreaterThan(0, count($erros));

        $this->data['itensPedido']['quantidade'] = 0;
        $erros = $this->validator->validate($this->data);
        $this->assertGreaterThan(0, count($erros));

        $this->data['itensPedido']['quantidade'] = 'a';
        $erros = $this->validator->validate($this->data);
        $this->assertGreaterThan(0, count($erros));
    }

    public function testDeveRetornarErroDistanciaInvalida()
    {
        unset($this->data['distancia']);
        $erros = $this->validator->validate($this->data);
        $this->assertGreaterThan(0, count($erros));

        $this->data['disntancia'] = 0;
        $erros = $this->validator->validate($this->data);
        $this->assertGreaterThan(0, count($erros));

        $this->data['distancia'] = 'a';
        $erros = $this->validator->validate($this->data);
        $this->assertGreaterThan(0, count($erros));
    }
}
