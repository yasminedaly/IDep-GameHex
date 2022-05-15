<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Tutos
 *
 * @ORM\Table(name="tutos")
 * @ORM\Entity
 */
class Tutos
{
    /**
     * @var int
     *
     * @ORM\Column(name="tutoID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $tutoid;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="string", length=65534, nullable=false)
     * @Assert\Length(
     *      min = 10,
     *      max = 65534,
     *      minMessage = "The tuto content must be at least {{ limit }} characters long",
     *      maxMessage = "The tuto content cannot be longer than {{ limit }} characters"
     * )
     */
    private $content;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=200, nullable=false)
     * @Assert\Length(
     *      min = 10,
     *      max = 80,
     *      minMessage = "The tuto title must be at least {{ limit }} characters long",
     *      maxMessage = "The tuto title cannot be longer than {{ limit }} characters"
     * )
     */
    private $title;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="tutos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    public function getTutoid(): ?int
    {
        return $this->tutoid;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }


}
