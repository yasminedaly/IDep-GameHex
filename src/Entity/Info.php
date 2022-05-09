<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Info
 *
 * @ORM\Table(name="info")
 * @ORM\Entity
 */
class Info
{
    /**
     * @var int
     *
     * @ORM\Column(name="contentID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $contentid;

    /**
     * @var string
     *
     * @ORM\Column(name="contentTitle", type="string", length=100, nullable=false)
     * @Assert\Length(
     *      min = 3,
     *      max = 70,
     *      minMessage = "The content title must be at least {{ limit }} characters long",
     *      maxMessage = "The e-content title cannot be longer than {{ limit }} characters"
     * )
     */
    private $contenttitle;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="contentDate", type="date", nullable=false)
     */
    private $contentdate;

    /**
     * @var string
     *
     * @ORM\Column(name="infoContent", type="text", length=65535, nullable=true)
     * @Assert\Length(
     *      min = 4,
     *      max = 40000,
     *      minMessage = "The content informations must be at least {{ limit }} characters long",
     *      maxMessage = "The content infos cannot be longer than {{ limit }} characters"
     * )
     */
    private $infocontent;

    /**
     * @var string
     *
     * @ORM\Column(name="ytContent", type="text", length=65535, nullable=true)
     * @Assert\Length(
     *      min = 4,
     *      max = 40000,
     *      minMessage = "The youtube content informations must be at least {{ limit }} characters long",
     *      maxMessage = "The youtube content infos cannot be longer than {{ limit }} characters"
     * )
     */
    private $ytContent;    

    public function getContentid(): ?int
    {
        return $this->contentid;
    }

    public function getContenttitle(): ?string
    {
        return $this->contenttitle;
    }

    public function setContenttitle(string $contenttitle): self
    {
        $this->contenttitle = $contenttitle;

        return $this;
    }

    public function getContentdate(): ?\DateTimeInterface
    {
        return $this->contentdate;
    }

    public function setContentdate(\DateTimeInterface $contentdate): self
    {
        $this->contentdate = $contentdate;

        return $this;
    }

    public function getInfocontent()
    {
        return $this->infocontent;
    }

    public function setInfocontent($infocontent): self
    {
        $this->infocontent = $infocontent;

        return $this;
    }

    public function getYtContent()
    {
        return $this->ytContent;
    }

    public function setYtContent($ytContent): self
    {
        $this->ytContent = $ytContent;

        return $this;
    }


}
