<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\CartRepository")
 */
class Cart
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="carts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ProductCart", mappedBy="cart")
     */
    private $productCart;

    public function __construct()
    {
        $this->productCart = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getProductCart(): Collection
    {
        return $this->productCart;
    }

    public function addProductCart(ProductCart $productCart): self
    {
        if(!$this->productCart->contains($productCart)){
            $this->productCart[] = $productCart;
            $productCart->setCart($this);
        }
        return $this;
    }

    public function removeProductCart(ProductCart $productCart): self
    {
        if($this->productCart->contains($productCart)){
            $this->productCart->removeElement($productCart);
            if($productCart->getCart() === $this){
                $productCart->setCart(null);
            }
        }
        return $this;
    }

    public function __toString()
    {
        return $this->getUser() . '\'s cart';
    }

}
