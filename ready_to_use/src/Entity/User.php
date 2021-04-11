<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface, \Serializable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private ?string $firstName;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private ?string $lastName;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private string $username;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $password;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private string $email;

    /**
     * @ORM\Column(type="datetime")
     */
    private \DateTimeInterface $signupDate;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private string $iban;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private string $address;

    /**
     * @ORM\OneToMany(targetEntity=UserVerification::class, mappedBy="requestingUser", orphanRemoval=true)
     */
    private $requestingUser;

    /**
     * @ORM\OneToMany(targetEntity=UserVerification::class, mappedBy="verifiedBy", orphanRemoval=true)
     */
    private $verifiedBy;

    /**
     * @ORM\OneToMany(targetEntity=Purchase::class, mappedBy="purchasedBy")
     */
    private $purchases;

    /**
     * @ORM\OneToMany(targetEntity=Sell::class, mappedBy="soldBy")
     */
    private $sells;

    public function __construct()
    {
        $this->requestingUser = new ArrayCollection();
        $this->verifiedBy = new ArrayCollection();
        $this->purchases = new ArrayCollection();
        $this->sells = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getSignupDate(): ?\DateTimeInterface
    {
        return $this->signupDate;
    }

    public function setSignupDate(\DateTimeInterface $signupDate): self
    {
        $this->signupDate = $signupDate;

        return $this;
    }

    public function getIban(): ?string
    {
        return $this->iban;
    }

    public function setIban(string $iban): self
    {
        $this->iban = $iban;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return Collection|UserVerification[]
     */
    public function getRequestingUser(): Collection
    {
        return $this->requestingUser;
    }

    public function addUserVerification(UserVerification $userVerification): self
    {
        if (!$this->requestingUser->contains($userVerification)) {
            $this->requestingUser[] = $userVerification;
            $userVerification->setRequestingUser($this);
        }

        return $this;
    }

    public function removeUserVerification(UserVerification $userVerification): self
    {
        if ($this->requestingUser->removeElement($userVerification)) {
            // set the owning side to null (unless already changed)
            if ($userVerification->getRequestingUser() === $this) {
                $userVerification->setRequestingUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|UserVerification[]
     */
    public function getVerifiedBy(): Collection
    {
        return $this->verifiedBy;
    }

    public function addVerifiedBy(UserVerification $verifiedBy): self
    {
        if (!$this->verifiedBy->contains($verifiedBy)) {
            $this->verifiedBy[] = $verifiedBy;
            $verifiedBy->setVerifiedBy($this);
        }

        return $this;
    }

    public function removeVerifiedBy(UserVerification $verifiedBy): self
    {
        if ($this->verifiedBy->removeElement($verifiedBy)) {
            // set the owning side to null (unless already changed)
            if ($verifiedBy->getVerifiedBy() === $this) {
                $verifiedBy->setVerifiedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Purchase[]
     */
    public function getPurchases(): Collection
    {
        return $this->purchases;
    }

    public function addPurchase(Purchase $purchase): self
    {
        if (!$this->purchases->contains($purchase)) {
            $this->purchases[] = $purchase;
            $purchase->setPurchasedBy($this);
        }

        return $this;
    }

    public function removePurchase(Purchase $purchase): self
    {
        if ($this->purchases->removeElement($purchase)) {
            // set the owning side to null (unless already changed)
            if ($purchase->getPurchasedBy() === $this) {
                $purchase->setPurchasedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Sell[]
     */
    public function getSells(): Collection
    {
        return $this->sells;
    }

    public function addSell(Sell $sell): self
    {
        if (!$this->sells->contains($sell)) {
            $this->sells[] = $sell;
            $sell->setSoldBy($this);
        }

        return $this;
    }

    public function removeSell(Sell $sell): self
    {
        if ($this->sells->removeElement($sell)) {
            // set the owning side to null (unless already changed)
            if ($sell->getSoldBy() === $this) {
                $sell->setSoldBy(null);
            }
        }

        return $this;
    }

    public function getRoles()
    {
        return ['ROLE_ADMIN'];
    }

    public function getSalt()
    {
    }

    public function eraseCredentials()
    {
    }

    public function serialize()
    {
        return serialize([
            $this->id,
            $this->username,
            $this->password
        ]);
    }

    public function unserialize($serialized)
    {
        list(
            $this->id,
            $this->username,
            $this->password
            ) = unserialize($serialized, ['allowed_classes' => false]);
    }

}
