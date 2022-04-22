<?php

namespace App\Entity;

use App\Repository\ItemPedidoRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ItemPedidoRepository::class)]
class ItemPedido
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['pedido'])]
    private $id;

    #[ORM\ManyToOne(targetEntity: Vinho::class)]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['pedido'])]
    private $vinho;

    #[ORM\Column(type: 'integer')]
    #[Groups(['pedido'])]
    private $quantidade;

    #[ORM\Column(type: 'float')]
    #[Groups(['pedido'])]
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
