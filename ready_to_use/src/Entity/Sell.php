<?php

namespace App\Entity;

use App\Repository\SellRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SellRepository::class)
 */
class Sell
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\OneToOne(targetEntity=Product::class, inversedBy="sell", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $product;

    /**
     * @ORM\Column(type="integer")
     */
    private int $status;

    /**
     * @ORM\Column(type="datetime")
     */
    private \DateTimeInterface $depositDate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private \DateTimeInterface $acceptedDate;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="sells")
     * @ORM\JoinColumn(nullable=false)
     */
    private $soldBy;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $counterOffer;

    /**
     * @ORM\Column(type="string", length=12, nullable=true)
     */
    private $voucher;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(Product $product): self
    {
        $this->product = $product;

        return $this;
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

    public function getDepositDate(): ?\DateTimeInterface
    {
        return $this->depositDate;
    }

    public function setDepositDate(\DateTimeInterface $depositDate): self
    {
        $this->depositDate = $depositDate;

        return $this;
    }

    public function getAcceptedDate(): ?\DateTimeInterface
    {
        return $this->acceptedDate;
    }

    public function setAcceptedDate(\DateTimeInterface $acceptedDate): self
    {
        $this->acceptedDate = $acceptedDate;

        return $this;
    }

    public function getSoldBy(): ?User
    {
        return $this->soldBy;
    }

    public function setSoldBy(?User $soldBy): self
    {
        $this->soldBy = $soldBy;

        return $this;
    }

    public function getCounterOffer(): ?float
    {
        return $this->counterOffer;
    }

    public function setCounterOffer(?float $counterOffer): self
    {
        $this->counterOffer = $counterOffer;

        return $this;
    }

    public function getVoucher(): ?string
    {
        return $this->voucher;
    }

    public function setVoucher(?string $voucher): self
    {
        $this->voucher = $voucher;

        return $this;
    }
}
