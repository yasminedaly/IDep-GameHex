<?php

namespace App\Entity;

use App\Repository\SessionRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=SessionRepository::class)
 */
class Session
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=25)
     * @Assert\NotBlank
     */
    private ?string $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank
     */
    private ?string $description;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\GreaterThanOrEqual("today UTC")
     * @Assert\NotBlank
     */
    private $start;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $link;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\NotBlank
     */
    private ?int $rating;

    /**
     * @ORM\ManyToOne(targetEntity=Coach::class, inversedBy="sessions")
     * @ORM\JoinColumn(nullable=false)
     */
    private ?Coach $coach;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="sessions")
     * @ORM\JoinColumn(nullable=false)
     */
    private ?User $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * @param mixed $start
     */
    public function setStart($start): void
    {
        $this->start = $start;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(?string $link): self
    {
        $this->link = $link;

        return $this;
    }

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function setRating(?int $rating): self
    {
        $this->rating = $rating;

        return $this;
    }

    public function getCoach(): ?Coach
    {
        return $this->coach;
    }

    public function setCoach(?Coach $coach): self
    {
        $this->coach = $coach;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user): void
    {
        $this->user = $user;
    }

}
