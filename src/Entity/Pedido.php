<?php

namespace App\Entity;

use App\Repository\PedidoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: PedidoRepository::class)]
class Pedido
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['pedido'])]
    private $id;

    #[ORM\Column(type: 'datetime')]
    #[Groups(['pedido'])]
    private $data;

    #[ORM\Column(type: 'float')]
    #[Groups(['pedido'])]
    private $valorFrete;

    #[ORM\Column(type: 'float')]
    #[Groups(['pedido'])]
    private $total;

    #[ORM\OneToMany(mappedBy: 'pedido', targetEntity: ItemPedido::class, orphanRemoval: true, cascade: ['persist'])]
    #[Groups(['pedido'])]
    private $itemPedidos;

    public function __construct()
    {
        $this->itemPedidos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getData(): ?\DateTimeInterface
    {
        return $this->data;
    }

    public function setData(\DateTimeInterface $data): self
    {
        $this->data = $data;

        return $this;
    }

    public function getValorFrete(): ?float
    {
        return $this->valorFrete;
    }

    public function setValorFrete(float $valorFrete): self
    {
        $this->valorFrete = $valorFrete;

        return $this;
    }

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(float $total): self
    {
        $this->total = $total;

        return $this;
    }

    /**
     * @return Collection<int, ItemPedido>
     */
    public function getItemPedidos(): Collection
    {
        return $this->itemPedidos;
    }

    public function addItemPedido(ItemPedido $itemPedido): self
    {
        if (!$this->itemPedidos->contains($itemPedido)) {
            $this->itemPedidos[] = $itemPedido;
            $itemPedido->setPedido($this);
        }

        return $this;
    }

    public function removeItemPedido(ItemPedido $itemPedido): self
    {
        if ($this->itemPedidos->removeElement($itemPedido)) {
            // set the owning side to null (unless already changed)
            if ($itemPedido->getPedido() === $this) {
                $itemPedido->setPedido(null);
            }
        }

        return $this;
    }
}
