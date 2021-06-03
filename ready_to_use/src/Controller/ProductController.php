<?php


namespace App\Controller;

use App\Entity\Order;
use App\Entity\Picture;
use App\Form\AddToCartType;
use App\Manager\CartManager;
use App\Repository\SellRepository;
use App\Repository\UserVerificationRepository;
use DateTime;
use App\Entity\Product;
use App\Entity\User;
use Stripe\Checkout\Session;
use Stripe\Exception\ApiErrorException;
use Stripe\Stripe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/product")
 */
class ProductController extends AbstractController
{
    /**
     * @Route("/", name="product.index")
     * @return Response
     */
    public function index(): Response
    {
        $products = $this->getDoctrine()->getRepository(Product::class)->findAll();

        return $this->render('/product/index.html.twig', [
            'products' => $products,
            'current_page' => 'product'
        ]);

    }

    /**
     * @Route("/{id}", name="product.show")
     * @param Product $product
     * @param Request $request
     * @param CartManager $cartManager
     * @return Response
     */
    public function show(Product $product, Request $request, CartManager $cartManager): Response
    {
        $form = $this->createForm(AddToCartType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $item = $form->getData();
            $condition = $form->get('productCondition')->getData();
            $product->setProductCondition($condition);
            $item->setProduct($product);

            $cart = $cartManager->getCurrentCart();
            $cart
                ->addProduct($item)
                ->setRequestDate(new \DateTime());

            $cartManager->save($cart);

            if ($item->getQuantity() > 1) $message = $item->getQuantity(). ' produits ont été ajouté au panier.';
            else $message = '1 produit a été ajouté au panier.';

            $this->addFlash('success', $message);
            return $this->redirectToRoute('product.show', ['id' => $product->getId()]);
        }

        $pictures = $this->getDoctrine()->getRepository(Picture::class)->findBy(['product' => $product]);

        return $this->render('/product/show.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
            'pictures' => $pictures,
            'current_page' => 'product'
        ]);
    }

}