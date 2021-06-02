<?php


namespace App\Controller;

use DateTime;
use App\Entity\Product;
use App\Entity\Purchase;
use App\Entity\User;
use Stripe\Checkout\Session;
use Stripe\Exception\ApiErrorException;
use Stripe\Stripe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/product")
 */
class ProductController extends AbstractController
{
    /**
     * @Route("/{id}/test", name="product.test", methods={"GET"})
     * @param Product $product
     * @return Response
     */
    public function test(Product $product): Response
    {
        return $this->render('merchant/product/test.html.twig', [
            'product' => $product,
            'current_page' => 'product'
        ]);
    }

    /**
     * @Route("/{id}/buy", name="product.buy", methods={"POST"})
     * @param Product $product
     * @return Response
     */
    public function buy(Product $product): Response
    {
        // création de la commande
        $purchase = new Purchase();
        $purchase->setProduct($product);
        $purchase->setStatus(0);
        $purchase->setCoinsEarned($product->getPrice() / 10); // à voir pour le calcul des jetons gagnés
        $purchase->setRequestDate(new DateTime());

        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['username' => $this->getUser()->getUsername()]);
        $purchase->setPurchasedBy($user);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($purchase);
        $entityManager->flush();

        Stripe::setApiKey('sk_test_51IxDjiKgLlknBEgu1oT1wW8OZLC2BPhSAf8buHUczm67oF3kbIWnQFtqkhcPDFsyiNmDz4kNdjuEtKUwgGM5cQJ000bl5uN1ty');

        // permt d'afficher les images sur l'onglet de paiement Stripe
        // à voir lorsque l'application sera déployé sur le serveur
        // $pictures = $this->getDoctrine()->getRepository(Picture::class)->findBy(['product' => $product]);

        // on crée une session de paiement Stripe
        try {
            $checkout_session = Session::create([
                'payment_method_types' => ['card'],
                'customer_email' => $user->getEmail(),
                'customer' => $user->getStripeCustomerId(),
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'eur',
                        'unit_amount' => $product->getPrice() * 100,
                        'product_data' => [
                            'name' => $product->getModel()->getName(),
//                             'images' => [$pictures],
                        ],
                    ],
                    'quantity' => 1,
                ]],
                'metadata' => [
                    'purchase_id' => $purchase->getId()
                ],
                'mode' => 'payment',
                // à changer plus tard
                'success_url' => $this->getParameter('domain') . '/purchase/',
                'cancel_url' => $this->getParameter('domain') . '/purchase/',
            ]);
        } catch (ApiErrorException $e) {
            return $this->json([
                'error' => 'Une erreur est survenue'
            ]);
        }

        return $this->json([
            'id' => $checkout_session->id
        ]);
    }

}