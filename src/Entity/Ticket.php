<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\TicketRepository;
use App\Validator\Ticket as TicketValidator;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=TicketRepository::class)
 * @ORM\HasLifecycleCallbacks
 * @TicketValidator
 */
class Ticket
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"tickets:read"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Flight::class, inversedBy="tickets")
     * @ORM\JoinColumn(nullable=false)
     */
    private $flight;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Range(
     *     min=1,
     *     max=150
     * )
     * @Groups({"tickets:read"})
     */
    private $seatNumber;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"tickets:read"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable = true)
     * @Groups({"tickets:read"})
     */
    private $updatedAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFlight(): ?Flight
    {
        return $this->flight;
    }

    public function setFlight(?Flight $flight): self
    {
        $this->flight = $flight;

        return $this;
    }

    public function getSeatNumber(): ?int
    {
        return $this->seatNumber;
    }

    public function setSeatNumber(int $seatNumber): self
    {
        $this->seatNumber = $seatNumber;

        return $this;
    }

    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt): Ticket
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updatedTimestamps(): void
    {
        $this->setUpdatedAt(new \DateTime('now'));
        if (null === $this->getCreatedAt()) {
            $this->setCreatedAt(new \DateTime('now'));
        }
    }

    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTimeInterface $updatedAt): Ticket
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
