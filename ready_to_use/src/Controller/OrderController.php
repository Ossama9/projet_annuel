<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\User;
use App\Manager\CartManager;
use App\Repository\OrderRepository;
use DateTime;
use Stripe\Checkout\Session;
use Stripe\Exception\ApiErrorException;
use Stripe\Exception\UnexpectedValueException;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Stripe;
use Stripe\Webhook;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/order")
 */
class OrderController extends AbstractController
{

    /**
     * @Route("/", name="order.index")
     * @param OrderRepository $orderRepository
     * @return Response
     */
    public function index(OrderRepository $orderRepository): Response
    {
        // on récupère les commandes de l'utilisateur (on ne prend pas en compte la commande dans le panier courant)
        $orders = $orderRepository->findBy(['orderedBy' => $this->getUser(), 'status' => !Order::STATUS_CART ]);

        return $this->render('/order/index.html.twig', [
            'orders' => $orders,
            'current_page' => 'order'
        ]);
    }

    /**
     * @Route("/{id}", name="order.show", methods={"GET"})
     * @param Order $order
     * @return Response
     */
    public function show(Order $order): Response
    {
        if ($order->getOrderedBy() === $this->getUser()) {

            return $this->render('/order/show.html.twig', [
                'order' => $order,
                'current_page' => 'order'
            ]);

        } else return $this->redirectToRoute('order.index');
    }

    /**
     * @Route("/{id}/invoice", name="order.invoice")
     * @param Order $order
     * @return Response
     */
    public function invoice(Order $order): Response
    {
        if ($order->getOrderedBy() === $this->getUser() || in_array('ROLE_ADMIN', $this->getUser()->getRoles())) {

            return $this->render('/order/invoice.html.twig', [
                'order' => $order,
                'current_page' => 'order'
            ]);

        } else return $this->redirectToRoute('order.index');
    }

    /**
     * Webhook Stripe pour mettre à jour le statut des commandes
     * @Route("/webhook", name="order.webhook", methods={"POST"})
     * @param Request $request
     * @return Response
     */
    public function order_webhook(Request $request): Response
    {
        $data = [];
        $entityManager = $this->getDoctrine()->getManager();

        // on configure les clés privées
        Stripe::setApiKey('sk_test_51IxDjiKgLlknBEgu1oT1wW8OZLC2BPhSAf8buHUczm67oF3kbIWnQFtqkhcPDFsyiNmDz4kNdjuEtKUwgGM5cQJ000bl5uN1ty');
        $endpoint_secret = 'whsec_WaIFQ6nzPyW2AXT1D7coY86I0cECHPbi';

        // on récupère le corps et les entêtes de la requête Stripe
        $payload = @file_get_contents('php://input');
        $sig_header = $request->server->get('HTTP_STRIPE_SIGNATURE');
        $event = null;

        try {
            $event = Webhook::constructEvent(
                $payload, $sig_header, $endpoint_secret
            );

        } catch(UnexpectedValueException $e) {
            // Invalid payload
            $data['error'] = 'Invalid payload';

            return new Response(json_encode($data), Response::HTTP_BAD_REQUEST);

        } catch(SignatureVerificationException $e) {
            // Invalid signature
            $data['error'] = 'Invalid signature';

            return new Response(json_encode($data), Response::HTTP_BAD_REQUEST);
        }

        $session = $event->data->object;
        $order = $this->getDoctrine()->getRepository(Order::class)->find($session['metadata']['order_id']);

        function fulfill_order($order) {
            // le paiement a bien été reçu
            $order->setStatus(1);
            $order->setPaidDate(new DateTime());
            $order->setDeliveryStatus(0);
        }

        switch ($event->type) {
            case 'checkout.session.completed':
                $data['session'] = $session;

                $user = $order->getOrderedBy();
                if (!$user->getStripeCustomerId()) $user->setStripeCustomerId($session['customer']);
                $entityManager->persist($user);

                // on regarde si la commande a bien été payé
                if ($session->payment_status == 'paid') {
                    fulfill_order($order);
                }

                break;

            case 'checkout.session.async_payment_succeeded':
                // paiement bien reçu
                fulfill_order($order);
                break;

            case 'checkout.session.async_payment_failed':
                // erreur lors du paiement
                $order->setStatus(2);
                break;
        }

        $entityManager->persist($order);
        $entityManager->flush();
        return new Response(json_encode($data), Response::HTTP_OK);
    }

    /**
     * @Route("/checkout", name="order.checkout", methods={"POST"})
     * @param CartManager $cartManager
     * @return Response
     */
    public function checkout(CartManager $cartManager): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['username' => $this->getUser()->getUsername()]);

        // récupération du panier
        $order = $cartManager->getCurrentCart();
        $order->setOrderedBy($user);
        $em = $this->getDoctrine()->getManager();
        $em->persist($order);
        $em->flush();

        Stripe::setApiKey('sk_test_51IxDjiKgLlknBEgu1oT1wW8OZLC2BPhSAf8buHUczm67oF3kbIWnQFtqkhcPDFsyiNmDz4kNdjuEtKUwgGM5cQJ000bl5uN1ty');

        // permt d'afficher les images sur l'onglet de paiement Stripe
        // à voir lorsque l'application sera déployé sur le serveur
        // $pictures = $this->getDoctrine()->getRepository(Picture::class)->findBy(['product' => $product]);

        // ajout des produits pour le paiement via Stripe
        $line_items = [];
        foreach ($order->getProducts() as $product) {
            $line_items[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'unit_amount' => $product->getProduct()->getPriceWithMargin() * 100,
                    'product_data' => [
                        'name' => $product->getProduct()->getModel()->getName()
                        // 'images' => [$pictures],
                    ]
                ],
                'quantity' => 1
            ];
        }

        // on crée une session de paiement Stripe
        try {
            $checkout_session = Session::create([
                'payment_method_types' => ['card'],
                'customer_email' => $user->getStripeCustomerId() ? null : $user->getEmail(),
                'customer' => $user->getStripeCustomerId(),
                'line_items' => $line_items,
                'metadata' => [
                    'order_id' => $order->getId()
                ],
                'mode' => 'payment',
                // à changer plus tard
                'success_url' => $this->getParameter('domain') . '/order/',
                'cancel_url' => $this->getParameter('domain') . '/order/',
            ]);
        } catch (ApiErrorException $e) {
            return $this->json([
                'error' => $e
            ]);
        }

        return $this->json([
            'id' => $checkout_session->id
        ]);
    }
}
