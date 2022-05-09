<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $name;

    /**
     * @ORM\Column(name="lastName", type="string", length=50)
     */
    private $lastName;

    /**
     * @ORM\Column(name="CIN", type="integer")
     * @Assert\Regex("/^[0-9]{8}$/")
     */
    private $CIN;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Type(type="integer")
     * @Assert\Regex("/^[0-9]{8}$/")
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @var string The hashed password
     * @ORM\Column(name="pwd", type="string")
     */
    private $password;

    /**
     * @ORM\Column(name="role", type="json")
     */
    private $roles = [];

    /**
     * @ORM\Column(type="boolean")
     */
    private $isVerified = false;

   /**
     * @ORM\Column(name="ban", type="boolean")
     */
    private $ban;

    /**
     * @ORM\Column(name="activate", type="boolean")
     */
    private $activate;

    /**
     * @ORM\OneToMany(targetEntity=Product::class, mappedBy="idUser", orphanRemoval=true)
     */
    private $products;

    /**
     * @ORM\OneToOne(targetEntity=Coach::class, mappedBy="user")
     */
    private $coach;

    /**
     * @ORM\OneToMany(targetEntity=Session::class, mappedBy="user")
     */
    private $sessions;

    /**
     * @ORM\OneToMany(targetEntity=Calendar::class, mappedBy="user")
     */
    private $calendar;

    /**
     * @ORM\OneToMany(targetEntity=Teams::class, mappedBy="user")
     */
    private $teams;



    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $locale;


    /**
     * @ORM\OneToMany(targetEntity=Order::class, mappedBy="user", orphanRemoval=true)
     */
    private $orders;

    public function __construct()
    {
        $this->products = new ArrayCollection();
        $this->orders = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getCalendar()
    {
        return $this->calendar;
    }

    /**
     * @param mixed $calendar
     */
    public function setCalendar($calendar): void
    {
        $this->calendar = $calendar;
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

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getCIN(): ?int
    {
        return $this->CIN;
    }

    public function setCIN(int $CIN): self
    {
        $this->CIN = $CIN;

        return $this;
    }

    public function getPhone(): ?int
    {
        return $this->phone;
    }

    public function setPhone(int $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getDate(): ?string
    {
        return $this->date;
    }

    public function setDate(string $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    public function getBan(): ?bool
    {
        return $this->ban;
    }

    public function setBan(bool $ban): self
    {
        $this->ban = $ban;

        return $this;
    }

    public function getActivate(): ?bool
    {
        return $this->activate;
    }

    public function setActivate(bool $activate): self
    {
        $this->activate = $activate;

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
            $product->setIdUser($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getIdUser() === $this) {
                $product->setIdUser(null);
            }
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCoach()
    {
        return $this->coach;
    }

    /**
     * @param mixed $coach
     */
    public function setCoach($coach): void
    {
        $this->coach = $coach;
    }

    /**
     * @return mixed
     */
    public function getSessions()
    {
        return $this->sessions;
    }

    /**
     * @param mixed $sessions
     */
    public function setSessions($sessions): void
    {
        $this->sessions = $sessions;
    }

    /**
     * @return mixed
     */
    public function getTeams()
    {
        return $this->teams;
    }

    /**
     * @param mixed $teams
     */
    public function setTeams($teams): void
    {
        $this->teams = $teams;
    }



    public function getLocale(): ?string
    {
        return $this->locale;
    }

    public function setLocale(?string $locale): self
    {
        $this->locale = $locale;

        return $this;
    }


    /**
     * @return Collection<int, Order>
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders[] = $order;
            $order->setUser($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): self
    {
        if ($this->orders->removeElement($order)) {
            // set the owning side to null (unless already changed)
            if ($order->getUser() === $this) {
                $order->setUser(null);
            }
        }

        return $this;
    }
}
