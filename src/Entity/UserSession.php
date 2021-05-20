<?php

namespace App\Entity;

use App\Repository\UserSessionRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserSessionRepository::class)
 * @UniqueEntity("email")
 */
class UserSession
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="userSessions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $LoggedInUser;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     *
     */
    private $apiKey;

    /**
     * @ORM\Column(type="datetime")
     */
    private $expiresAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLoggedInUser(): ?User
    {
        return $this->LoggedInUser;
    }

    public function setLoggedInUser(?User $LoggedInUser): self
    {
        $this->LoggedInUser = $LoggedInUser;

        return $this;
    }

    public function getApiKey(): ?string
    {
        return $this->apiKey;
    }

    public function setApiKey(string $apiKey): self
    {
        $this->apiKey = $apiKey;

        return $this;
    }

    public function getExpiresAt(): ?\DateTimeInterface
    {
        return $this->expiresAt;
    }

    public function setExpiresAt(\DateTimeInterface $expiresAt): self
    {
        $this->expiresAt = $expiresAt;

        return $this;
    }
}
