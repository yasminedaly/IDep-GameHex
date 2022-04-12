<?php

namespace App\Entity;

use App\Repository\MatchesRepository;
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
     * @ORM\ManyToOne(targetEntity=Teams::class, inversedBy="matches")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank
     */
    private $team1;

    /**
     * @ORM\ManyToOne(targetEntity=Teams::class, inversedBy="matches")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank
     */
    private $team2;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $matchRes;

    /**
     * @ORM\Column(type="string", length=300)
     * @Assert\NotBlank
     */
    private $matchCom;

    /**
     * @ORM\Column(type="date")
     * @Assert\GreaterThan("today UTC")
     */
    private $matchDate;

    /**
     * @ORM\Column(type="time")
     */
    private $matchTime;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTeam1(): ?Teams
    {
        return $this->team1;
    }

    public function setTeam1(?Teams $team1): self
    {
        $this->team1 = $team1;

        return $this;
    }

    public function getTeam2(): ?Teams
    {
        return $this->team2;
    }

    public function setTeam2(?Teams $team2): self
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
}
