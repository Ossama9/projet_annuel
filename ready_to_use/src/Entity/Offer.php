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
     * @ORM\ManyToMany(targetEntity=model::class, inversedBy="offers")
     */
    private $model;

    public function __construct()
    {
        $this->model = new ArrayCollection();
    }

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

    /**
     * @return Collection|model[]
     */
    public function getModel(): Collection
    {
        return $this->model;
    }

    public function addModel(model $model): self
    {
        if (!$this->model->contains($model)) {
            $this->model[] = $model;
        }

        return $this;
    }

    public function removeModel(model $model): self
    {
        $this->model->removeElement($model);

        return $this;
    }
}
