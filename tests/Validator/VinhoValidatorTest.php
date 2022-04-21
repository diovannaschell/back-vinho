<?php

namespace App\Tests\Validator;

use App\Validator\VinhoValidator;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class VinhoValidatorTest extends WebTestCase
{
    private array $data;

    public VinhoValidator $validator;

    public function setUp(): void
    {
        $this->validator = new VinhoValidator();

        $this->data = [
            'nome' => 'vinho de teste',
            'tipo' => 'seco',
            'peso' => 1.5,
            'valor' => 27.8
        ];
    }

    public function testNaoDeveRetornarErroComParametrosValidos()
    {
        $erros = $this->validator->validate($this->data);
        $this->assertCount(0, $erros);
    }

    public function testDeveRetornarErroSemNome()
    {
        $this->data['nome'] = '';
        $erros = $this->validator->validate($this->data);
        $this->assertGreaterThan(0, count($erros));

        unset($this->data['nome']);
        $erros = $this->validator->validate($this->data);
        $this->assertGreaterThan(0, count($erros));
    }

    public function testDeveRetornarErroSemTipo()
    {
        $this->data['tipo'] = '';
        $erros = $this->validator->validate($this->data);
        $this->assertGreaterThan(0, count($erros));

        unset($this->data['tipo']);
        $erros = $this->validator->validate($this->data);
        $this->assertGreaterThan(0, count($erros));
    }

    public function testDeveRetornarErroPesoInvalido()
    {
        $this->data['peso'] = '';
        $erros = $this->validator->validate($this->data);
        $this->assertGreaterThan(0, count($erros));

        $this->data['peso'] = 0;
        $erros = $this->validator->validate($this->data);
        $this->assertGreaterThan(0, count($erros));

        unset($this->data['peso']);
        $erros = $this->validator->validate($this->data);
        $this->assertGreaterThan(0, count($erros));
    }

    public function testDeveRetornarErroValorInvalido()
    {
        $this->data['valor'] = '';
        $erros = $this->validator->validate($this->data);
        $this->assertGreaterThan(0, count($erros));

        $this->data['valor'] = 0;
        $erros = $this->validator->validate($this->data);
        $this->assertGreaterThan(0, count($erros));

        unset($this->data['valor']);
        $erros = $this->validator->validate($this->data);
        $this->assertGreaterThan(0, count($erros));
    }
}
