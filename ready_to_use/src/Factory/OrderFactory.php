<?php


namespace App\Factory;


use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\Product;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrderFactory extends AbstractController
{

    /**
     * Création d'une commande
     * @return Order
     */
    public function create(): Order
    {
        $order = new Order();

        $order
            ->setStatus(Order::STATUS_CART)
            ->setRequestDate(new \DateTime());

        return $order;
    }

    /**
     * Création d'un produit achetable
     * @param Product $product
     *
     * @return OrderItem
     */
    public function createItem(Product $product): OrderItem
    {
        $item = new OrderItem();
        $item->setProduct($product);
        $item->setQuantity(1);

        return $item;
    }

}