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
     *      min = 10,
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
     * @ORM\Column(name="infoContent", type="text", length=65535, nullable=false)
     * @Assert\Length(
     *      min = 30,
     *      max = 40000,
     *      minMessage = "The content informations must be at least {{ limit }} characters long",
     *      maxMessage = "The content infos cannot be longer than {{ limit }} characters"
     * )
     */
    private $infocontent;

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

    public function getInfocontent(): ?string
    {
        return $this->infocontent;
    }

    public function setInfocontent(string $infocontent): self
    {
        $this->infocontent = $infocontent;

        return $this;
    }


}
