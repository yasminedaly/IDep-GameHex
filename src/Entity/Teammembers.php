<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Teammembers
 *
 * @ORM\Table(name="teammembers", indexes={@ORM\Index(name="team_members_FK", columns={"teamId"})})
 * @ORM\Entity
 */
class Teammembers
{
    /**
     * @var int
     *
     * @ORM\Column(name="riotId", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $riotid;

    /**
     * @var string
     *
     * @ORM\Column(name="memberRole", type="string", length=255, nullable=false)
     */
    private $memberrole;

    /**
     * @var int
     *
     * @ORM\Column(name="memberPhone", type="integer", nullable=false)
     */
    private $memberphone;

    /**
     * @var string
     *
     * @ORM\Column(name="memberMail", type="string", length=255, nullable=false)
     */
    private $membermail;

    /**
     * @var int
     *
     * @ORM\Column(name="userID", type="integer", nullable=false)
     */
    private $userid;

    /**
     * @var \Teams
     *
     * @ORM\ManyToOne(targetEntity="Teams")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="teamId", referencedColumnName="teamId")
     * })
     */
    private $teamid;

    public function getRiotid(): ?int
    {
        return $this->riotid;
    }

    public function getMemberrole(): ?string
    {
        return $this->memberrole;
    }

    public function setMemberrole(string $memberrole): self
    {
        $this->memberrole = $memberrole;

        return $this;
    }

    public function getMemberphone(): ?int
    {
        return $this->memberphone;
    }

    public function setMemberphone(int $memberphone): self
    {
        $this->memberphone = $memberphone;

        return $this;
    }

    public function getMembermail(): ?string
    {
        return $this->membermail;
    }

    public function setMembermail(string $membermail): self
    {
        $this->membermail = $membermail;

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

    public function getTeamid(): ?Teams
    {
        return $this->teamid;
    }

    public function setTeamid(?Teams $teamid): self
    {
        $this->teamid = $teamid;

        return $this;
    }


}
