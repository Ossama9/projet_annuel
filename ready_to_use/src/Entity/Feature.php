<?php

namespace App\Entity;

use App\Repository\FeatureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
     * @ORM\OneToMany(targetEntity=Model::class, mappedBy="feature")
     */
    private $models;

    public function __construct()
    {
        $this->models = new ArrayCollection();
    }

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

    /**
     * @return Collection|Model[]
     */
    public function getModels(): Collection
    {
        return $this->models;
    }

    public function addModel(Model $model): self
    {
        if (!$this->models->contains($model)) {
            $this->models[] = $model;
            $model->setFeature($this);
        }

        return $this;
    }

    public function removeModel(Model $model): self
    {
        if ($this->models->removeElement($model)) {
            // set the owning side to null (unless already changed)
            if ($model->getFeature() === $this) {
                $model->setFeature(null);
            }
        }

        return $this;
    }

    public function toArray(): array
    {
        $array = array();
        /*foreach (get_object_vars($this) as $key => $att){
            $array[$key] = $att;
        }*/
        return get_object_vars($this);
    }
}
