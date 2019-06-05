<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\ProductCartRepository")
 */
class ProductCart
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Product", inversedBy="productCart")
     * @ORM\JoinColumn(nullable=false)
     */
    private $product;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Cart", inversedBy="productCart")
     * @ORM\JoinColumn(nullable=false)
     */
    private $cart;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduct()
    {
        return $this->product;
    }

    public function setProduct($product): void
    {
        $this->product = $product;
    }

    public function getCart()
    {
        return $this->cart;
    }

    public function setCart($cart): void
    {
        $this->cart = $cart;
    }

    public function __toString()
    {
        return $this->getCart() . ' - ' . $this->getProduct();
    }
}
