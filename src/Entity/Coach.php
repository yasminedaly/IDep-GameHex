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
    private $id;

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
    private $rating;

    /**
     * @ORM\Column(type="string", length=25)
     * @Assert\NotBlank
     */
    private $tier;

    /**
     * @ORM\OneToMany(targetEntity=Session::class, mappedBy="coach")
     */
    private $sessions;

    public function __construct()
    {
        $this->sessions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
}
