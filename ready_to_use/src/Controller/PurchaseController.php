<?php

namespace App\Controller;

use App\Entity\Purchase;
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
 * @Route("/purchase")
 */
class PurchaseController extends AbstractController
{

    /**
     * @Route("/", name="purchase.index")
     * @return Response
     */
    public function index(): Response
    {
        // on récupère les achats de l'utilisateur
        $purchases = $this->getDoctrine()->getRepository(Purchase::class)->findBy(['purchasedBy' => $this->getUser()]);

        return $this->render('/purchase/index.html.twig', [
            'purchases' => $purchases,
            'current_page' => 'purchase'
        ]);
    }

    /**
     * Webhook Stripe pour mettre à jour le statut des commandes
     * @Route("/webhook", name="purchase.webhook", methods={"POST"})
     * @param Request $request
     * @return Response
     */
    public function purchase_webhook(Request $request): Response
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

        function fulfill_order($purchase) {
            // le paiement a bien été reçu
            $purchase->setStatus(1);
            $purchase->setPaidDate(new DateTime());
        }

        $session = $event->data->object;
        $purchase = $this->getDoctrine()->getRepository(Purchase::class)->find($session['metadata']['purchase_id']);

        switch ($event->type) {
            case 'checkout.session.completed':
                $data['session'] = $session;

                $user = $purchase->getPurchasedBy();
                if ($user->getStripeCustomerId() === null) $user->setStripeCustomerId($session['customer']);
                $entityManager->persist($user);

                // on regarde si la commande a bien été payé
                if ($session->payment_status == 'paid') {
                    fulfill_order($purchase);
                }

                break;

            case 'checkout.session.async_payment_succeeded':
                // paiement bien reçu
                fulfill_order($purchase);
                break;

            case 'checkout.session.async_payment_failed':
                // erreur lors du paiement
                $purchase->setStatus(2);
                break;
        }

        $entityManager->persist($purchase);
        $entityManager->flush();
        return new Response(json_encode($data), Response::HTTP_OK);
    }
}
