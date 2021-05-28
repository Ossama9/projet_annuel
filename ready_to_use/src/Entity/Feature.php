<?php

namespace App\Entity;

use App\Repository\FeatureRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FeatureRepository::class)
 */
class Feature
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $battery;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private ?string $camera;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private ?string $graphicCard;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private ?string $hardDisk;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private ?string $osVersion;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private ?string $processor;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $ram;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private ?string $screenSize;

    /**
     * @ORM\Column(type="boolean")
     */
    private ?bool $tactile;

    /**
     * @ORM\OneToOne(targetEntity=Product::class, inversedBy="feature", cascade={"persist", "remove"})
     */
    private $product;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBattery(): ?int
    {
        return $this->battery;
    }

    public function setBattery(?int $battery): self
    {
        $this->battery = $battery;

        return $this;
    }

    public function getCamera(): ?string
    {
        return $this->camera;
    }

    public function setCamera(?string $camera): self
    {
        $this->camera = $camera;

        return $this;
    }

    public function getGraphicCard(): ?string
    {
        return $this->graphicCard;
    }

    public function setGraphicCard(?string $graphicCard): self
    {
        $this->graphicCard = $graphicCard;

        return $this;
    }

    public function getHardDisk(): ?string
    {
        return $this->hardDisk;
    }

    public function setHardDisk(?string $hardDisk): self
    {
        $this->hardDisk = $hardDisk;

        return $this;
    }

    public function getOsVersion(): ?string
    {
        return $this->osVersion;
    }

    public function setOsVersion(?string $osVersion): self
    {
        $this->osVersion = $osVersion;

        return $this;
    }

    public function getProcessor(): ?string
    {
        return $this->processor;
    }

    public function setProcessor(?string $processor): self
    {
        $this->processor = $processor;

        return $this;
    }

    public function getRam(): ?int
    {
        return $this->ram;
    }

    public function setRam(?int $ram): self
    {
        $this->ram = $ram;

        return $this;
    }

    public function getScreenSize(): ?string
    {
        return $this->screenSize;
    }

    public function setScreenSize(?string $screenSize): self
    {
        $this->screenSize = $screenSize;

        return $this;
    }

    public function getTactile(): ?bool
    {
        return $this->tactile;
    }

    public function setTactile(?bool $tactile): self
    {
        $this->tactile = $tactile;

        return $this;
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
}
