<?php

namespace App\Entity;

use App\Repository\ModelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ModelRepository::class)
 */
class Model
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $releaseDate;

    /**
     * @ORM\ManyToOne(targetEntity=Brand::class, inversedBy="models")
     */
    private $brand;

    /**
     * @ORM\OneToMany(targetEntity=Offer::class, mappedBy="model")
     */
    private $offers;

    /**
     * @ORM\OneToMany(targetEntity=Product::class, mappedBy="model")
     */
    private $products;

    /**
     * @ORM\Column(type="boolean")
     */
    private $showBatteryField;

    /**
     * @ORM\Column(type="boolean")
     */
    private $showCameraField;

    /**
     * @ORM\Column(type="boolean")
     */
    private $showGraphicCardField;

    /**
     * @ORM\Column(type="boolean")
     */
    private $showHardDiskField;

    /**
     * @ORM\Column(type="boolean")
     */
    private $showOsVersionField;

    /**
     * @ORM\Column(type="boolean")
     */
    private $showProcessorField;

    /**
     * @ORM\Column(type="boolean")
     */
    private $showRamField;

    /**
     * @ORM\Column(type="boolean")
     */
    private $showScreenField;

    /**
     * @ORM\Column(type="boolean")
     */
    private $showTactileField;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="models")
     */
    private $category;

    public function __construct()
    {
        $this->offers = new ArrayCollection();
        $this->products = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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

    public function getReleaseDate(): ?\DateTimeInterface
    {
        return $this->releaseDate;
    }

    public function setReleaseDate(?\DateTimeInterface $releaseDate): self
    {
        $this->releaseDate = $releaseDate;

        return $this;
    }

    public function getBrand(): ?Brand
    {
        return $this->brand;
    }

    public function setBrand(?Brand $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * @return Collection|Offer[]
     */
    public function getOffers(): Collection
    {
        return $this->offers;
    }

    public function addOffer(Offer $offer): self
    {
        if (!$this->offers->contains($offer)) {
            $this->offers[] = $offer;
            $offer->setModel($this);
        }

        return $this;
    }

    public function removeOffer(Offer $offer): self
    {
        if ($this->offers->removeElement($offer)) {
            // set the owning side to null (unless already changed)
            if ($offer->getModel() === $this) {
                $offer->setModel(null);
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
        $this->feature = $feature;

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
            $product->setModel($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getModel() === $this) {
                $product->setModel(null);
            }
        }

        return $this;
    }

    public function getShowBatteryField(): ?bool
    {
        return $this->showBatteryField;
    }

    public function setShowBatteryField(bool $showBatteryField): self
    {
        $this->showBatteryField = $showBatteryField;

        return $this;
    }

    public function getShowCameraField(): ?bool
    {
        return $this->showCameraField;
    }

    public function setShowCameraField(bool $showCameraField): self
    {
        $this->showCameraField = $showCameraField;

        return $this;
    }

    public function getShowGraphicCardField(): ?bool
    {
        return $this->showGraphicCardField;
    }

    public function setShowGraphicCardField(bool $showGraphicCardField): self
    {
        $this->showGraphicCardField = $showGraphicCardField;

        return $this;
    }

    public function getShowHardDiskField(): ?bool
    {
        return $this->showHardDiskField;
    }

    public function setShowHardDiskField(bool $showHardDiskField): self
    {
        $this->showHardDiskField = $showHardDiskField;

        return $this;
    }

    public function getShowOsVersionField(): ?bool
    {
        return $this->showOsVersionField;
    }

    public function setShowOsVersionField(bool $showOsVersionField): self
    {
        $this->showOsVersionField = $showOsVersionField;

        return $this;
    }

    public function getShowProcessorField(): ?bool
    {
        return $this->showProcessorField;
    }

    public function setShowProcessorField(bool $showProcessorField): self
    {
        $this->showProcessorField = $showProcessorField;

        return $this;
    }

    public function getShowRamField(): ?bool
    {
        return $this->showRamField;
    }

    public function setShowRamField(bool $showRamField): self
    {
        $this->showRamField = $showRamField;

        return $this;
    }

    public function getShowScreenField(): ?bool
    {
        return $this->showScreenField;
    }

    public function setShowScreenField(bool $showScreenField): self
    {
        $this->showScreenField = $showScreenField;

        return $this;
    }

    public function getShowTactileField(): ?bool
    {
        return $this->showTactileField;
    }

    public function setShowTactileField(bool $showTactileField): self
    {
        $this->showTactileField = $showTactileField;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }
}
