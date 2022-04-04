<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Supplier
 *
 * @ORM\Table(name="supplier")
 * @ORM\Entity
 */
class Supplier
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_supplier", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idSupplier;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=50, nullable=false)
     */
    private $name;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="start_date", type="date", nullable=true)
     */
    private $startDate;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="leave_date", type="date", nullable=true)
     */
    private $leaveDate;

    /**
     * @var int
     *
     * @ORM\Column(name="nbr_units_sold", type="integer", nullable=false)
     */
    private $nbrUnitsSold;

    public function getIdSupplier(): ?int
    {
        return $this->idSupplier;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(?\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getLeaveDate(): ?\DateTimeInterface
    {
        return $this->leaveDate;
    }

    public function setLeaveDate(?\DateTimeInterface $leaveDate): self
    {
        $this->leaveDate = $leaveDate;

        return $this;
    }

    public function getNbrUnitsSold(): ?int
    {
        return $this->nbrUnitsSold;
    }

    public function setNbrUnitsSold(int $nbrUnitsSold): self
    {
        $this->nbrUnitsSold = $nbrUnitsSold;

        return $this;
    }


}
