<?php

namespace App\Entity;

use App\Repository\TeamsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=TeamsRepository::class)
 */
class Teams
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Groups("post:read")
     */
    private $teamName;

    /**
     * @ORM\Column(type="string", length=3)
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 3,
     *      max = 3,
     *      minMessage = "Your team tag must be at least {{ limit }} characters long",
     *      maxMessage = "Your team tag cannot be longer than {{ limit }} characters"
     * )
     * @Groups("post:read")
     */
    private $teamTag;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email."
     * )
     * @Groups("post:read")
     */
    private $teamMail;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Groups("post:read")
     */
    private $teamReg;


    /**
     * @ORM\OneToMany(targetEntity=TeamMates::class, mappedBy="team", orphanRemoval=true)
     */
    private $teamMates;

    /**
     * @ORM\OneToMany(targetEntity=Matches::class, mappedBy="team1")
     */
    private $matches;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $teamLogo;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="teams")
     * @ORM\JoinColumn(nullable=false)
     */
    private ?User $user;

    public function __construct()
    {
        $this->matches = new ArrayCollection();
        $this->teamMates = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTeamName(): ?string
    {
        return $this->teamName;
    }



    public function setTeamName(string $teamName): self
    {
        $this->teamName = $teamName;

        return $this;
    }

    public function getTeamTag(): ?string
    {
        return $this->teamTag;
    }

    public function setTeamTag(string $teamTag): self
    {
        $this->teamTag = $teamTag;

        return $this;
    }

    public function getTeamMail(): ?string
    {
        return $this->teamMail;
    }

    public function setTeamMail(string $teamMail): self
    {
        $this->teamMail = $teamMail;

        return $this;
    }

    public function getTeamReg(): ?string
    {
        return $this->teamReg;
    }

    public function setTeamReg(string $teamReg): self
    {
        $this->teamReg = $teamReg;

        return $this;
    }

    /**
     * @return Collection<int, Matches>
     */
    public function getMatches(): Collection
    {
        return $this->matches;
    }

    public function addMatch(Matches $match): self
    {
        if (!$this->matches->contains($match)) {
            $this->matches[] = $match;
            $match->addTeam($this);
        }

        return $this;
    }

    public function removeMatch(Matches $match): self
    {
        if ($this->matches->removeElement($match)) {
            $match->removeTeam($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, TeamMates>
     */
    public function getTeamMates(): Collection
    {
        return $this->teamMates;
    }

    public function addTeamMate(TeamMates $teamMate): self
    {
        if (!$this->teamMates->contains($teamMate)) {
            $this->teamMates[] = $teamMate;
            $teamMate->setTeam($this);
        }

        return $this;
    }

    public function removeTeamMate(TeamMates $teamMate): self
    {
        if ($this->teamMates->removeElement($teamMate)) {
            // set the owning side to null (unless already changed)
            if ($teamMate->getTeam() === $this) {
                $teamMate->setTeam(null);
            }
        }

        return $this;
    }

    public function getTeamLogo(): ?string
    {
        return $this->teamLogo;
    }

    public function setTeamLogo(string $teamLogo): self
    {
        $this->teamLogo = $teamLogo;

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
    public function setUser(?User $user): void
    {
        $this->user = $user;
    }

}
