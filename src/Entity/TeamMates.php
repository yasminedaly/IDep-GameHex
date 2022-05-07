<?php

namespace App\Entity;

use App\Repository\TeamMatesRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=TeamMatesRepository::class)
 */
class TeamMates
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 4,
     *      max = 4,
     *      minMessage = "Your riot id must be at least {{ limit }} characters long",
     *      maxMessage = "Your riot id cannot be longer than {{ limit }} characters"
     * )
     */
    private $riotId;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $memberRole;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 8,
     *      max = 8,
     *      minMessage = "Your phone number must be at least {{ limit }} digits",
     *      maxMessage = "Your phone number cannot be longer than {{ limit }} digits"
     * )
     */
    private $memberPhone;

    /**
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email."
     * )
     * @ORM\Column(type="string", length=255)
     */
    private $memberMail;

    /**
     * @ORM\ManyToOne(targetEntity=Teams::class, inversedBy="teamMates")
     * @ORM\JoinColumn(nullable=false)
     */
    private $team;

    public function getRiotId(): ?int
    {
        return $this->riotId;
    }

    public function getMemberRole(): ?string
    {
        return $this->memberRole;
    }

    public function setMemberRole(string $memberRole): self
    {
        $this->memberRole = $memberRole;

        return $this;
    }

    public function getMemberPhone(): ?int
    {
        return $this->memberPhone;
    }
    public function setRiotId(int $riotId): self
    {
        $this->riotId = $riotId;

        return $this;
    }

    public function setMemberPhone(int $memberPhone): self
    {
        $this->memberPhone = $memberPhone;

        return $this;
    }


    public function getMemberMail(): ?string
    {
        return $this->memberMail;
    }

    public function setMemberMail(string $memberMail): self
    {
        $this->memberMail = $memberMail;

        return $this;
    }

    public function getTeam(): ?Teams
    {
        return $this->team;
    }

    public function setTeam(?Teams $team): self
    {
        $this->team = $team;

        return $this;
    }
}
