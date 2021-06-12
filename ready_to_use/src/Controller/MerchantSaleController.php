<?php


namespace App\Controller;

use App\Entity\Model;
use App\Entity\Offer;
use App\Entity\Order;
use App\Entity\Picture;
use App\Entity\Product;
use App\Entity\Sell;
use App\Entity\User;
use App\Form\ProductType;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use App\Repository\SellRepository;
use App\Repository\UserVerificationRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * @Route("/merchant/sale")
 */
class MerchantSaleController extends AbstractController
{

    /**
     * @Route("/", name="merchant.sale.index")
     * @param OrderRepository $orderRepository
     * @param SellRepository $sellRepository
     * @param ProductRepository $productRepository
     * @return Response
     */
    public function index(OrderRepository $orderRepository, SellRepository $sellRepository,ProductRepository $productRepository): Response
    {
        $sell = $sellRepository->findBy(['soldBy' => $this->getUser()]);
        $products = $productRepository->findBy(['sell' => $sell]);
        $sells = $orderRepository->findBy(['status' => !Order::STATUS_CART, 'products' => $products]);
        foreach ($sells as $sell) {
            $products[] = $sell->getProducts();
        }

        dump($products);

        return $this->render('/merchant/sale/index.html.twig', [
            'products' => $products,
            'current_page' => 'merchant.product'
        ]);

    }
}