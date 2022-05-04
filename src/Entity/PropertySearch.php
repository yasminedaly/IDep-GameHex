<?php

namespace App\Entity;

use App\Repository\PropertySearchRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PropertySearchRepository::class)
 */
class PropertySearch
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $maxprice;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $availablity;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMaxprice(): ?int
    {
        return $this->maxprice;
    }

    public function setMaxprice(int $maxprice): self
    {
        $this->maxprice = $maxprice;

        return $this;
    }

    public function getAvailablity(): ?int
    {
        return $this->availablity;
    }

    public function setAvailablity(?int $availablity): self
    {
        $this->availablity = $availablity;

        return $this;
    }
}
