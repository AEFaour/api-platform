<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\RangeFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"read", "task"}},
 *     denormalizationContext={"groups"={"write"}},
 *     itemOperations={
 *         "get",
 *         "put"={
 *             "denormalization_context"={"groups"={"put"}}
 *         }
 *     },
 *        attributes={
 *       "pagination_items_per_page": 20
 *     },
 * )
 * @ORM\Entity(repositoryClass="App\Repository\TaskRepository")
 * @ApiFilter(SearchFilter::class, properties={"id": "exact", "name": "exact", "time": "exact", "priority": "exact", "user.id" = "exact" })
 * @ApiFilter(RangeFilter::class, properties={"time", "priority"})
 * @ApiFilter(OrderFilter::class, properties={"id", "time", "priority"})
 * @ApiFilter(DateFilter::class, properties={"createdAt"})
 */
class Task
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read", "write"})
     * @Assert\NotBlank(message="Il est impératif d'intégrer le nom de la tâche! ")
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read", "write", "put"})
     * @Assert\NotBlank(message="Il est impératif d'intégrer le time de la tâche! ")
     */
    private $time;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"read", "write", "put"})
     * @Assert\Range(
     *     min = 30,
     *     max = 80,
     *     minMessage="Le nombre mini est 30",
     *     maxMessage="Le nombre maxi est 90"
     * )
     */
    private $priority;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="tasks")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"read", "write", "task"})
     * @Assert\NotBlank(message="Il est impératif d'intégrer l'utilisateur de la tâche! ")
     */
    private $user;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"read"})
     */
    private $createdAt;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getTime(): ?string
    {
        return $this->time;
    }

    public function setTime(string $time): self
    {
        $this->time = $time;

        return $this;
    }

    public function getPriority(): ?int
    {
        return $this->priority;
    }

    public function setPriority(int $priority): self
    {
        $this->priority = $priority;

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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
