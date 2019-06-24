<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CartController extends AbstractController
{
    public function validate(Request $request, $cartId)
    {
        $em = $this->getDoctrine()->getManager();

        $cart = $em->find('App\Entity\Cart', $cartId);
        if($cart === null){
            throw $this->createNotFoundException("The cart doesn't exist");
        }

        if($cart->getBought()){
            throw new Exception('Panier déjà validé');
        }

        foreach($cart->getProducts() as $product){
            $stock = $product->getStock();
            if($stock < 1){
                throw new Exception('Pas assez de stock pour le produit ' . $product->getId());
            } else {
                $product->setStock($stock - 1);
            }
            $em->persist($product);
        }
        $cart->setBought(true);
        $em->persist($cart);

        $em->flush();

        return new Response('Panier validé !');
    }
}