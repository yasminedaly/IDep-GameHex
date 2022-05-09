<?php

namespace App\Entity;

use App\Repository\CoachRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CoachRepository::class)
 */
class Coach
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 1,
     *      max = 1,
     *      minMessage = "The rating must be at least {{ limit }} characters long",
     *      maxMessage = "The rating cannot be longer than {{ limit }} characters"
     * )
     * @Assert\Range(
     *      min = 0,
     *      max = 5,
     *      notInRangeMessage = "Rating must be between {{ min }} and {{ max }}",
     * )
     */
    private ?float $rating;

    /**
     * @ORM\Column(type="string", length=25)
     * @Assert\NotBlank
     */
    private ?string $tier;

    /**
     * @ORM\OneToMany(targetEntity=Session::class, mappedBy="coach")
     */
    private $sessions;


    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private ?string $imageUrl;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $motto;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="coach")
     * @ORM\JoinColumn(name="user_id", nullable=false)
     */
    private ?User $user;

    /**
     * @ORM\OneToMany(targetEntity=Calendar::class, mappedBy="calendarCoach")
     */
    private $calendar;

    public function __construct()
    {
        $this->sessions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getCalendar()
    {
        return $this->calendar;
    }

    /**
     * @param mixed $calendar
     */
    public function setCalendar($calendar): void
    {
        $this->calendar = $calendar;
    }

    public function getRating(): ?float
    {
        return $this->rating;
    }

    public function setRating(?float $rating): self
    {
        $this->rating = $rating;

        return $this;
    }

    public function getTier(): ?string
    {
        return $this->tier;
    }

    public function setTier(string $tier): self
    {
        $this->tier = $tier;

        return $this;
    }

    /**
     * @return Collection<int, Session>
     */
    public function getSessions(): Collection
    {
        return $this->sessions;
    }

    public function addSession(Session $session): self
    {
        if (!$this->sessions->contains($session)) {
            $this->sessions[] = $session;
            $session->setCoach($this);
        }

        return $this;
    }

    public function removeSession(Session $session): self
    {
        if ($this->sessions->removeElement($session)) {
            // set the owning side to null (unless already changed)
            if ($session->getCoach() === $this) {
                $session->setCoach(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Session>
     */
    public function getCalendarSessions(): Collection
    {
        return $this->calendarSessions;
    }

    public function addCalendarSession(Calendar $calendarSessions): self
    {
        if (!$this->sessions->contains($calendarSessions)) {
            $this->sessions[] = $calendarSessions;
            $calendarSessions->setCoach($this);
        }

        return $this;
    }

    public function removeCalendarSession(Calendar $calendarSessions): self
    {
        if ($this->sessions->removeElement($calendarSessions)) {
            // set the owning side to null (unless already changed)
            if ($calendarSessions->getCoach() === $this) {
                $calendarSessions->setCoach(null);
            }
        }

        return $this;
    }

    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    public function setImageUrl(?string $imageUrl): self
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }

    public function getMotto(): ?string
    {
        return $this->motto;
    }

    public function setMotto(?string $motto): self
    {
        $this->motto = $motto;

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

