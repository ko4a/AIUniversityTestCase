<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\FlightRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=FlightRepository::class)
 * @ORM\HasLifecycleCallbacks
 */
class Flight
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"flight:read"})
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=Ticket::class, mappedBy="flight", orphanRemoval=true)
     */
    private $tickets;

    /**
     * @ORM\OneToMany(targetEntity=Reservation::class, mappedBy="flight", orphanRemoval=true)
     */
    private $reservations;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"flight:read"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable = true)
     * @Groups({"flight:read"})
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="boolean")
     */
    private $salesCompleted = false;

    public function __construct()
    {
        $this->tickets = new ArrayCollection();
        $this->reservations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Ticket[]
     */
    public function getTickets(): Collection
    {
        return $this->tickets;
    }

    public function addTicket(Ticket $ticket): self
    {
        if (!$this->tickets->contains($ticket)) {
            $this->tickets[] = $ticket;
            $ticket->setFlight($this);
        }

        return $this;
    }

    public function removeTicket(Ticket $ticket): self
    {
        if ($this->tickets->removeElement($ticket)) {
            if ($ticket->getFlight() === $this) {
                $ticket->setFlight(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Reservation[]
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): self
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations[] = $reservation;
            $reservation->setFlight($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): self
    {
        if ($this->reservations->removeElement($reservation)) {
            if ($reservation->getFlight() === $this) {
                $reservation->setFlight(null);
            }
        }

        return $this;
    }

    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt): Flight
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

    public function setUpdatedAt(DateTimeInterface $updatedAt): Flight
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function isSalesCompleted(): ?bool
    {
        return $this->salesCompleted;
    }

    public function setSalesCompleted(bool $salesCompleted): self
    {
        $this->salesCompleted = $salesCompleted;

        return $this;
    }
}
