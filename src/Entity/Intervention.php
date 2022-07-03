<?php

namespace App\Entity;

use App\Repository\InterventionRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Customer;

#[ORM\Entity(repositoryClass: InterventionRepository::class)]
class Intervention
{
    public function __construct()
    {
        $this->date = new \DateTime();
    }
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'date')]
    private $date;

    #[ORM\Column(type: 'time', nullable: true)]
    private $startAt;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $duration;

    #[ORM\Column(type: 'time', nullable: true)]
    private $stopAt;

    #[ORM\Column(type: 'boolean')]
    private $donePaid;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'intervention')]
    private $user;

    #[ORM\ManyToOne(targetEntity: customer::class, inversedBy: 'interventions')]
    private $customer;

    #[ORM\Column(type: 'datetime_immutable')]
    private $createdAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getStartAt(): ?\DateTimeInterface
    {
        return $this->startAt;
    }

    public function setStartAt(\DateTimeInterface $startAt): self
    {
        $this->startAt = $startAt;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(?int $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getStopAt(): ?\DateTimeInterface
    {
        return $this->stopAt;
    }

    public function setStopAt(?\DateTimeInterface $stopAt): self
    {
        $this->stopAt = $stopAt;

        return $this;
    }

    public function isDonePaid(): ?bool
    {
        return $this->donePaid;
    }

    public function setDonePaid(bool $donePaid): self
    {
        $this->donePaid = $donePaid;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getCustomer(): ?customer
    {
        return $this->customer;
    }

    public function setCustomer(?customer $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
