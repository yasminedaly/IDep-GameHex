<?php

namespace App\Entity;

use App\Repository\MatchesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity(repositoryClass=MatchesRepository::class)
 */
class Matches
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     */
    private $team1;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     */
    private $team2;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $matchRes;

    /**
     * @ORM\Column(type="string", length=300)
     * @Assert\NotBlank
     */
    private $matchCom;

    /**
     * @ORM\Column(type="date")
     */
    private $matchDate;

    /**
     * @ORM\Column(type="time")
     */
    private $matchTime;

    /**
     * @ORM\ManyToMany(targetEntity=Teams::class, inversedBy="matches")
     */
    private $teams;

    public function __construct()
    {
        $this->teams = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTeam1(): ?int
    {
        return $this->team1;
    }

    public function setTeam1(int $team1): self
    {
        $this->team1 = $team1;

        return $this;
    }

    public function getTeam2(): ?int
    {
        return $this->team2;
    }

    public function setTeam2(int $team2): self
    {
        $this->team2 = $team2;

        return $this;
    }

    public function getMatchRes(): ?string
    {
        return $this->matchRes;
    }

    public function setMatchRes(string $matchRes): self
    {
        $this->matchRes = $matchRes;

        return $this;
    }

    public function getMatchCom(): ?string
    {
        return $this->matchCom;
    }

    public function setMatchCom(string $matchCom): self
    {
        $this->matchCom = $matchCom;

        return $this;
    }

    public function getMatchDate(): ?\DateTimeInterface
    {
        return $this->matchDate;
    }

    public function setMatchDate(\DateTimeInterface $matchDate): self
    {
        $this->matchDate = $matchDate;

        return $this;
    }

    public function getMatchTime(): ?\DateTimeInterface
    {
        return $this->matchTime;
    }

    public function setMatchTime(\DateTimeInterface $matchTime): self
    {
        $this->matchTime = $matchTime;

        return $this;
    }

    /**
     * @return Collection<int, Teams>
     */
    public function getTeams(): Collection
    {
        return $this->teams;
    }

    public function addTeam(Teams $team): self
    {
        if (!$this->teams->contains($team)) {
            $this->teams[] = $team;
        }

        return $this;
    }

    public function removeTeam(Teams $team): self
    {
        $this->teams->removeElement($team);

        return $this;
    }
}
