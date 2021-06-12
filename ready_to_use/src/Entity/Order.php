<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrderRepository::class)
 * @ORM\Table(name="`order`")
 */
class Order
{
    // ce statut signifit que les produits sont encore dans le panier, la commande n'a pas encore été payée
    public const STATUS_CART = 0;
    public const STATUS = [
        'Dans le panier',
        'Payé',
        'Livraison en cours',
        'Livré'
    ];

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $status = self::STATUS_CART;

    /**
     * @ORM\Column(type="datetime")
     */
    private $requestDate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $paidDate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $cancelDate;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="orders")
     */
    private $orderedBy;

    /**
     * @ORM\OneToMany(targetEntity=OrderItem::class, mappedBy="orderRef", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getStatusToString(): string
    {
        return self::STATUS[$this->status];
    }

    public function getRequestDate(): ?\DateTimeInterface
    {
        return $this->requestDate;
    }

    public function setRequestDate(\DateTimeInterface $requestDate): self
    {
        $this->requestDate = $requestDate;

        return $this;
    }

    public function getPaidDate(): ?\DateTimeInterface
    {
        return $this->paidDate;
    }

    public function setPaidDate(?\DateTimeInterface $paidDate): self
    {
        $this->paidDate = $paidDate;

        return $this;
    }

    public function getCancelDate(): ?\DateTimeInterface
    {
        return $this->cancelDate;
    }

    public function setCancelDate(?\DateTimeInterface $cancelDate): self
    {
        $this->cancelDate = $cancelDate;

        return $this;
    }

    public function getOrderedBy(): ?User
    {
        return $this->orderedBy;
    }

    public function setOrderedBy(?User $user): self
    {
        $this->orderedBy = $user;

        return $this;
    }

    /**
     * @return Collection|OrderItem[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(OrderItem $item): self
    {
        foreach ($this->getProducts() as $existingItem) {
            // Si le produit est déjà dans le panier, on ne fait rien
            if ($existingItem->equals($item)) return $this;
        }

        $this->products[] = $item;
        $item->setOrderRef($this);

        return $this;
    }

    public function removeProduct(OrderItem $item): self
    {
        if ($this->products->removeElement($item)) {
            // set the owning side to null (unless already changed)
            if ($item->getOrderRef() === $this) {
                $item->setOrderRef(null);
            }
        }

        return $this;
    }

    public function removeProducts(): self
    {
        foreach ($this->getProducts() as $product) {
            $this->removeProduct($product);
        }

        return $this;
    }

    /**
     * Retourne le nombre total de produits dans le panier
     * @return int
     */
    public function countProducts(): int
    {
        return count($this->getProducts());
    }

    /**
     * Retourne le montant total de la commande
     * @return float
     */
    public function getTotal(): float
    {
        $total = 0;

        foreach ($this->getProducts() as $item) $total += $item->getTotal();

        return $total;
    }
}
