<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use http\Encoding\Stream\Deflate;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
class Product
{
    public const CONDITIONS = [
        'Mauvais état',
        'Bon état',
        'Très bon état',
        'Comme neuf'
    ];

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
     * @ORM\OneToMany(targetEntity=Picture::class, mappedBy="product", cascade={"persist", "remove"})
     */
    private $pictures;

    /**
     * @ORM\OneToOne(targetEntity=Sell::class, mappedBy="product", cascade={"persist", "remove"})
     */
    private $sell;

    /**
     * @ORM\ManyToOne(targetEntity=Model::class, inversedBy="products")
     */
    private $model;

    /**
     * @ORM\Column(type="integer")
     */
    private $productCondition;

    /**
     * @ORM\ManyToOne(targetEntity=Feature::class, inversedBy="products", cascade={"persist"})
     */
    private $feature;

    public function __construct()
    {
        $this->pictures = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * Prix de vente sans la marge de 30% (montant que le marchand reçoit)
     * @return float|null
     */
    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Prix de vente affiché aux clients avec la marge de 30%
     * @return float|null
     */
    public function getPriceWithMargin(): ?float
    {
        return round($this->price * 1.3, 0);
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

    public function getModel(): ?Model
    {
        return $this->model;
    }

    public function setModel(?Model $model): self
    {
        $this->model = $model;

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

    public function getProductConditionToString(): string
    {
        return self::CONDITIONS[$this->productCondition];
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
     * Permet de rendre un produit modifiable ou non, par un marchand
     * @return bool
     */
    public function isEditable(): bool
    {
        return $this->getSell()->getStatus() !== 1;
    }
}
