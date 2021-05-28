<?php

namespace App\Entity;

use App\Repository\OfferRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OfferRepository::class)
 */
class Offer
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
    private $productCondition;

    /**
     * @ORM\Column(type="float")
     */
    private $amount;

    /**
     * @ORM\ManyToOne(targetEntity=model::class, inversedBy="offers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $model;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProductCondition(): ?int
    {
        return $this->productCondition;
    }

    public function setProductCondition(int $productCondition): self
    {
        $this->productCondition = $productCondition;

        return $this;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getModel(): ?model
    {
        return $this->model;
    }

    public function setModel(?model $model): self
    {
        $this->model = $model;

        return $this;
    }

}
