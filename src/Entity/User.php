<?php


namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ApiResource(
 *     attributes={"access_control"="is_granted('ROLE_ADMIN')"}
 * )
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=500)
     */
    private $password;


    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Cart", mappedBy="user", cascade={"persist", "remove"})
     */
    private $carts;

    /**
     * @ORM\Column(name="is_admin", type="boolean")
     */
    private $isAdmin = false;

    /**
     * @ORM\Column(type="string")
     */
    private $country = 'fr';


    public function __construct($username)
    {
        $this->isActive = true;
        $this->username = $username;
        $this->carts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getSalt()
    {
        return null;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password){
        $this->password = $password;
    }

    public function getIsAdmin(): bool
    {
        return $this->isAdmin;
    }

    public function setIsAdmin(bool $isAdmin): void
    {
        $this->isAdmin = $isAdmin;
    }

    public function getRoles()
    {
        var_dump('test');
        return $this->isAdmin ? ['ROLE_ADMIN'] : ['ROLE_USER'];
    }

    public function eraseCredentials()
    {
    }

    /**
     * @return Collection|Cart[]
     */
    public function getCarts(): Collection
    {
        return $this->carts;
    }

    public function addCart(Cart $cart): self
    {
        if(!$this->carts->contains($cart)){
            $this->carts[] = $cart;
            $cart->setUser($this);
        }
        return $this;
    }

    public function removeCart(Cart $cart): self
    {
        if ($this->carts->contains($cart)){
            $this->carts->removeElement($cart);
            if($cart->getUser() === $this){
                $cart->setUser(null);
            }
        }
        return $this;
    }

    public function getCountry()
    {
        return $this->country;
    }

    public function setCountry($country): void
    {
        $this->country = $country;
    }

    public function __toString()
    {
        return $this->getUsername();
    }
}