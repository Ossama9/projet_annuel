<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    private ?string $description;

    /**
     * @ORM\Column(type="float")
     */
    private float $price;

    /**
     * @ORM\Column(type="datetime")
     */
    private \DateTimeInterface $depositDate;

    /**
     * @ORM\ManyToOne(targetEntity=Wharehouse::class, inversedBy="products")
     * @ORM\JoinColumn(nullable=true)
     */
    private $wharehouse;

    /**
     * @ORM\OneToMany(targetEntity=Picture::class, mappedBy="product")
     */
    private $pictures;

    /**
     * @ORM\OneToOne(targetEntity=Feature::class, mappedBy="product", cascade={"persist", "remove"})
     */
    private $feature;

    /**
     * @ORM\OneToOne(targetEntity=Purchase::class, mappedBy="product", cascade={"persist", "remove"})
     */
    private $purchase;

    /**
     * @ORM\OneToOne(targetEntity=Sell::class, mappedBy="product", cascade={"persist", "remove"})
     */
    private $sell;

    /**
     * @ORM\OneToOne(targetEntity=Offer::class, cascade={"persist", "remove"})
     */
    private $offer;

    public function __construct()
    {
        $this->pictures = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(string $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
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

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

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

    public function getWharehouse(): ?Wharehouse
    {
        return $this->wharehouse;
    }

    public function setWharehouse(?Wharehouse $wharehouse): self
    {
        $this->wharehouse = $wharehouse;

        return $this;
    }

    /**
     * @return Collection|Picture[]
     */
    public function getPictures(): Collection
    {
        return $this->pictures;
    }

    public function addPicture(Picture $picture): self
    {
        if (!$this->pictures->contains($picture)) {
            $this->pictures[] = $picture;
            $picture->setProduct($this);
        }

        return $this;
    }

    public function removePicture(Picture $picture): self
    {
        if ($this->pictures->removeElement($picture)) {
            // set the owning side to null (unless already changed)
            if ($picture->getProduct() === $this) {
                $picture->setProduct(null);
            }
        }

        return $this;
    }

    public function getFeature(): ?Feature
    {
        return $this->feature;
    }

    public function setFeature(?Feature $feature): self
    {
        // unset the owning side of the relation if necessary
        if ($feature === null && $this->feature !== null) {
            $this->feature->setProduct(null);
        }

        // set the owning side of the relation if necessary
        if ($feature !== null && $feature->getProduct() !== $this) {
            $feature->setProduct($this);
        }

        $this->feature = $feature;

        return $this;
    }

    public function getPurchase(): ?Purchase
    {
        return $this->purchase;
    }

    public function setPurchase(Purchase $purchase): self
    {
        // set the owning side of the relation if necessary
        if ($purchase->getProduct() !== $this) {
            $purchase->setProduct($this);
        }

        $this->purchase = $purchase;

        return $this;
    }

    public function getSell(): ?Sell
    {
        return $this->sell;
    }

    public function setSell(Sell $sell): self
    {
        // set the owning side of the relation if necessary
        if ($sell->getProduct() !== $this) {
            $sell->setProduct($this);
        }

        $this->sell = $sell;

        return $this;
    }

    public function getOffer(): ?Offer
    {
        return $this->offer;
    }

    public function setOffer(?Offer $offer): self
    {
        $this->offer = $offer;

        return $this;
    }
}
