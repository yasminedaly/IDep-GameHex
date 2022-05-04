<?php

namespace App\Entity;

use App\Repository\SupplierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=SupplierRepository::class)
 */
class Supplier
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $name;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Assert\Expression(
     *     "this.getLeaveDate() >= this.getStartDate()",
     *     message="Leave date should be greater than start date !"
     * )
     */
    private $start_date;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Assert\Expression(
     *     "this.getLeaveDate() >= this.getStartDate()",
     *     message="Leave date should be greater than start date !"
     * )
     */
    private $leave_date;

    /**
     * @ORM\Column(type="integer", nullable=true)
     
     */
    private $nvr_units_sold;

    /**
     * @ORM\OneToMany(targetEntity=Product::class, mappedBy="supplier", orphanRemoval=true)
     */
    private $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->name;
    }

    public function getId(): ?int
    {
        return $this->id;
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
        return $this->start_date;
    }

    public function setStartDate(?\DateTimeInterface $start_date): self
    {
        $this->start_date = $start_date;

        return $this;
    }

    public function getLeaveDate(): ?\DateTimeInterface
    {
        return $this->leave_date;
    }

    public function setLeaveDate(?\DateTimeInterface $leave_date): self
    {
        $this->leave_date = $leave_date;

        return $this;
    }

    public function getNvrUnitsSold(): ?int
    {
        return $this->nvr_units_sold;
    }

    public function setNvrUnitsSold(?int $nvr_units_sold): self
    {
        $this->nvr_units_sold = $nvr_units_sold;

        return $this;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->setSupplier($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getSupplier() === $this) {
                $product->setSupplier(null);
            }
        }

        return $this;
    }
}
