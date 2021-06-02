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
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $status;

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
     * @ORM\ManyToMany(targetEntity=Product::class, inversedBy="orders")
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
     * @return Collection|Product[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        $this->products->removeElement($product);

        return $this;
    }

    public function getTotalPrice(): ?float
    {
        $totalPrice = 0;
        foreach ($this->getProducts() as $product) $totalPrice += $product->getPrice();

        return $totalPrice;
    }
}
