<?php

namespace App\Entity;

use App\Repository\VinhoRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: VinhoRepository::class)]
class Vinho
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['pedido'])]
    private $id;

    #[ORM\Column(type: 'string', length: 100)]
    #[Groups(['pedido'])]
    private $nome;

    #[ORM\Column(type: 'string', length: 100)]
    #[Groups(['pedido'])]
    private $tipo;

    #[ORM\Column(type: 'float')]
    #[Groups(['pedido'])]
    private $peso;

    #[ORM\Column(type: 'float')]
    private $valor;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getNome(): ?string
    {
        return $this->nome;
    }

    public function setNome(string $nome): self
    {
        $this->nome = $nome;

        return $this;
    }

    public function getTipo(): ?string
    {
        return $this->tipo;
    }

    public function setTipo(string $tipo): self
    {
        $this->tipo = $tipo;

        return $this;
    }

    public function getPeso(): ?float
    {
        return $this->peso;
    }

    public function setPeso(float $peso): self
    {
        $this->peso = $peso;

        return $this;
    }

    public function getValor(): ?float
    {
        return $this->valor;
    }

    public function setValor(float $valor): self
    {
        $this->valor = $valor;

        return $this;
    }
}
