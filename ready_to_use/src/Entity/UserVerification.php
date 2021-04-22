<?php

namespace App\Entity;

use App\Repository\UserVerificationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserVerificationRepository::class)
 */
class UserVerification
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="integer")
     */
    private int $status;

    /**
     * @ORM\Column(type="datetime")
     */
    private \DateTimeInterface $requestDate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?\DateTimeInterface $validationDate;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="requestingUser")
     * @ORM\JoinColumn(nullable=false)
     */
    private $requestingUser;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="verifiedBy")
     * @ORM\JoinColumn(nullable=true)
     */
    private $verifiedBy;

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

    public function getValidationDate(): ?\DateTimeInterface
    {
        return $this->validationDate;
    }

    public function setValidationDate(\DateTimeInterface $validationDate): self
    {
        $this->validationDate = $validationDate;

        return $this;
    }

    public function getRequestingUser(): ?User
    {
        return $this->requestingUser;
    }

    public function setRequestingUser(?User $requestingUser): self
    {
        $this->requestingUser = $requestingUser;

        return $this;
    }

    public function getVerifiedBy(): ?User
    {
        return $this->verifiedBy;
    }

    public function setVerifiedBy(?User $verifiedBy): self
    {
        $this->verifiedBy = $verifiedBy;

        return $this;
    }
}
