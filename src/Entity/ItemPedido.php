<?php

namespace App\Entity;

use App\Repository\ItemPedidoRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ItemPedidoRepository::class)]
class ItemPedido
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Vinho::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $vinho;

    #[ORM\Column(type: 'integer')]
    private $quantidade;

    #[ORM\Column(type: 'float')]
    private $valorUnitario;

    #[ORM\ManyToOne(targetEntity: Pedido::class, inversedBy: 'itemPedidos')]
    #[ORM\JoinColumn(nullable: false)]
    private $pedido;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVinho(): ?Vinho
    {
        return $this->vinho;
    }

    public function setVinho(?Vinho $vinho): self
    {
        $this->vinho = $vinho;

        return $this;
    }

    public function getQuantidade(): ?int
    {
        return $this->quantidade;
    }

    public function setQuantidade(int $quantidade): self
    {
        $this->quantidade = $quantidade;

        return $this;
    }

    public function getValorUnitario(): ?float
    {
        return $this->valorUnitario;
    }

    public function setValorUnitario(float $valorUnitario): self
    {
        $this->valorUnitario = $valorUnitario;

        return $this;
    }

    public function getPedido(): ?Pedido
    {
        return $this->pedido;
    }

    public function setPedido(?Pedido $pedido): self
    {
        $this->pedido = $pedido;

        return $this;
    }
}
