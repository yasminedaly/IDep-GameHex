<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Matches
 *
 * @ORM\Table(name="matches")
 * @ORM\Entity
 */
class Matches
{
    /**
     * @var int
     *
     * @ORM\Column(name="matchid", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $matchid;

    /**
     * @var int
     *
     * @ORM\Column(name="team1", type="integer", nullable=false)
     */
    private $team1;

    /**
     * @var int
     *
     * @ORM\Column(name="team2", type="integer", nullable=false)
     */
    private $team2;

    /**
     * @var string
     *
     * @ORM\Column(name="matchres", type="string", length=255, nullable=false)
     */
    private $matchres;

    /**
     * @var string
     *
     * @ORM\Column(name="matchcom", type="string", length=300, nullable=false)
     */
    private $matchcom;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="matchdate", type="date", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $matchdate = 'CURRENT_TIMESTAMP';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="matchtime", type="time", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $matchtime = 'CURRENT_TIMESTAMP';

    public function getMatchid(): ?int
    {
        return $this->matchid;
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

    public function getMatchres(): ?string
    {
        return $this->matchres;
    }

    public function setMatchres(string $matchres): self
    {
        $this->matchres = $matchres;

        return $this;
    }

    public function getMatchcom(): ?string
    {
        return $this->matchcom;
    }

    public function setMatchcom(string $matchcom): self
    {
        $this->matchcom = $matchcom;

        return $this;
    }

    public function getMatchdate(): ?\DateTimeInterface
    {
        return $this->matchdate;
    }

    public function setMatchdate(\DateTimeInterface $matchdate): self
    {
        $this->matchdate = $matchdate;

        return $this;
    }

    public function getMatchtime(): ?\DateTimeInterface
    {
        return $this->matchtime;
    }

    public function setMatchtime(\DateTimeInterface $matchtime): self
    {
        $this->matchtime = $matchtime;

        return $this;
    }


}
