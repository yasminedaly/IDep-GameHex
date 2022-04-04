<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Games
 *
 * @ORM\Table(name="games")
 * @ORM\Entity
 */
class Games
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
     * @ORM\Column(name="gamingContent", type="blob", length=65535, nullable=false)
     */
    private $gamingcontent;

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

    public function getGamingcontent()
    {
        return $this->gamingcontent;
    }

    public function setGamingcontent($gamingcontent): self
    {
        $this->gamingcontent = $gamingcontent;

        return $this;
    }


}
