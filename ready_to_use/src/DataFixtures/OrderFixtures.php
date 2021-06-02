<?php

namespace App\DataFixtures;

use App\Entity\Order;
use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class OrderFixtures extends Fixture
{
    /**
     * @var UserRepository
     */
    private UserRepository $userRepository;
    /**
     * @var ProductRepository
     */
    private ProductRepository $productRepository;

    public function __construct(UserRepository $userRepository, ProductRepository $productRepository)
    {
        $this->userRepository = $userRepository;
        $this->productRepository = $productRepository;
    }

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $order = new Order();
        $order->setStatus(0);
        $order->setRequestDate(new \DateTime());
        $orderedBy = $this->userRepository->find(16);
        $order->setOrderedBy($orderedBy);

        $product_1 = $this->productRepository->find(6);
        $product_2 = $this->productRepository->find(15);

        $order->addProduct($product_1);
        $order->addProduct($product_2);

        $manager->persist($order);
        $manager->flush();
    }
}
