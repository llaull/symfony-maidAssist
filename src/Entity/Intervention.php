<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Controller\CreateBookPublication;
use App\Repository\InterventionRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: InterventionRepository::class)]
#[ApiResource(
    itemOperations: [
        'get' => [
            // 'normalization_context' => ['collection']
        ]
        // 'delete', 
        // 'put'
    ],
    collectionOperations: [
        'get',
        // 'post'
    ],
    attributes: [
        'pagination_enabled' => false
    ]
)]
#[ApiFilter(SearchFilter::class, properties: [
    'duration' => SearchFilter::STRATEGY_EXACT,
    'user'=> SearchFilter::STRATEGY_EXACT,
])]
#[ApiFilter(
    OrderFilter::class,
    properties: [
        'duration',
        'date',
        'startAt',
        'user'
    ]
)]
// #[ApiResource(itemOperations: [
//         'get','put'
//         ])]
// #[ApiResource(itemOperations: [
//     'get',
//     'post_publication' => [
//         'method' => 'POST',
//         'path' => '/books/{id}/publication',
//         'controller' => CreateBookPublication::class,
//     ],
// ])]
class Intervention
{
    public function __construct()
    {
        $this->date = new \DateTime();
    }

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['collection'])]
    private $id;

    #[ORM\Column(type: 'date')]
    #[Groups(['collection'])]
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
    #[Groups(['collection'])]
    private $user;

    #[ORM\ManyToOne(targetEntity: Customer::class, inversedBy: 'interventions')]
    #[Groups(['collection'])]
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
