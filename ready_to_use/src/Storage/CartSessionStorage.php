<?php


namespace App\Storage;

use App\Entity\Order;
use App\Repository\OrderRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartSessionStorage
{
    /**
     * @var SessionInterface
     */
    private SessionInterface $session;

    /**
     * @var OrderRepository
     */
    private OrderRepository $cartRepository;

    /**
     * @var string
     */
    const CART_KEY_NAME = 'cart_id';

    /**
     * @param SessionInterface $session
     * @param OrderRepository $cartRepository
     */
    public function __construct(SessionInterface $session, OrderRepository $cartRepository)
    {
        $this->session = $session;
        $this->cartRepository = $cartRepository;
    }

    /**
     * Récupérer le panier
     * @return Order|null
     */
    public function getCart(): ?Order
    {
        return $this->cartRepository->findOneBy([
            'id' => $this->getCartId(),
            'status' => Order::STATUS_CART
        ]);
    }

    /**
     * @param Order $cart
     */
    public function setCart(Order $cart): void
    {
        $this->session->set(self::CART_KEY_NAME, $cart->getId());
    }

    /**
     * @return int|null
     */
    private function getCartId(): ?int
    {
        return $this->session->get(self::CART_KEY_NAME);
    }
}