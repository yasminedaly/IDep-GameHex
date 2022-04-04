<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Teams
 *
 * @ORM\Table(name="teams")
 * @ORM\Entity
 */
class Teams
{
    /**
     * @var int
     *
     * @ORM\Column(name="teamId", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $teamid;

    /**
     * @var string
     *
     * @ORM\Column(name="teamName", type="string", length=255, nullable=false)
     */
    private $teamname;

    /**
     * @var string
     *
     * @ORM\Column(name="teamTag", type="string", length=3, nullable=false)
     */
    private $teamtag;

    /**
     * @var string
     *
     * @ORM\Column(name="teamMail", type="string", length=255, nullable=false)
     */
    private $teammail;

    /**
     * @var string
     *
     * @ORM\Column(name="teamReg", type="string", length=255, nullable=false)
     */
    private $teamreg;

    /**
     * @var int
     *
     * @ORM\Column(name="userID", type="integer", nullable=false)
     */
    private $userid;

    public function getTeamid(): ?int
    {
        return $this->teamid;
    }

    public function getTeamname(): ?string
    {
        return $this->teamname;
    }

    public function setTeamname(string $teamname): self
    {
        $this->teamname = $teamname;

        return $this;
    }

    public function getTeamtag(): ?string
    {
        return $this->teamtag;
    }

    public function setTeamtag(string $teamtag): self
    {
        $this->teamtag = $teamtag;

        return $this;
    }

    public function getTeammail(): ?string
    {
        return $this->teammail;
    }

    public function setTeammail(string $teammail): self
    {
        $this->teammail = $teammail;

        return $this;
    }

    public function getTeamreg(): ?string
    {
        return $this->teamreg;
    }

    public function setTeamreg(string $teamreg): self
    {
        $this->teamreg = $teamreg;

        return $this;
    }

    public function getUserid(): ?int
    {
        return $this->userid;
    }

    public function setUserid(int $userid): self
    {
        $this->userid = $userid;

        return $this;
    }


}
