<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\Picture;
use App\Entity\Product;
use App\Entity\User;
use DateTime;
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
     * @return Response
     */
    public function index(): Response
    {
        // on récupère les commandes de l'utilisateur
        $orders = $this->getDoctrine()->getRepository(Order::class)->findBy(['orderedBy' => $this->getUser()]);

        return $this->render('/order/index.html.twig', [
            'orders' => $orders,
            'current_page' => 'order'
        ]);
    }

    /**
     * @Route("/{id}", name="order.show")
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
        if ($order->getOrderedBy() === $this->getUser()) {

            $price = 0;
            foreach ($order->getProducts() as $product) $price += $product->getPrice();

            return $this->render('/order/invoice.html.twig', [
                'order' => $order,
                'price' => $price,
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

        function fulfill_order($order) {
            // le paiement a bien été reçu
            $order->setStatus(1);
            $order->setPaidDate(new DateTime());
        }

        $session = $event->data->object;
        $order = $this->getDoctrine()->getRepository(Order::class)->find($session['metadata']['order_id']);

        switch ($event->type) {
            case 'checkout.session.completed':
                $data['session'] = $session;

                $user = $order->getOrderedBy();
                if ($user->getStripeCustomerId() === null) $user->setStripeCustomerId($session['customer']);
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
}
