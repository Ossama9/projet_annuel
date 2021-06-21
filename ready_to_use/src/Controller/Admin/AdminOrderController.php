<?php

namespace App\Controller\Admin;

use App\Entity\Order;
use App\Entity\Product;
use App\Form\OrderDeliveryStatusType;
use App\Form\ProductWharehouseType;
use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/order")
 */
class AdminOrderController extends AbstractController
{
    /**
     * @Route("/", name="admin.order.index", methods={"GET"})
     * @param OrderRepository $orderRepository
     * @return Response
     */
    public function index(OrderRepository $orderRepository): Response
    {
        // on récupère les commandes de l'utilisateur (on ne prend pas en compte la commande dans le panier courant)
        $orders = $orderRepository->findBy(['status' => !Order::STATUS_CART ]);

        return $this->render('admin/order/index.html.twig', [
            'orders' => $orders
        ]);
    }

    /**
     * @Route("/{id}", name="admin.order.show", methods={"GET"})
     * @param Order $order
     * @return Response
     */
    public function show(Order $order): Response
    {
        return $this->render('admin/order/show.html.twig', [
            'order' => $order,
        ]);
    }

    /**
     * @Route("/{id}", name="admin.order.delete", methods={"POST"})
     * @param Request $request
     * @param Order $order
     * @return Response
     */
    public function delete(Request $request, Order $order): Response
    {
        if ($this->isCsrfTokenValid('delete'.$order->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($order);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin.order.index');
    }

    /**
     * Permet à un administrateur de mettre à jour le suivi de livraison d'une commande
     * @Route("/{id}/update-delivery-status", name="admin.order.update_delivery_status", methods={"GET", "POST"})
     * @param Request $request
     * @param Order $order
     * @return Response
     */
    public function updateDeliveryStatus(Request $request, Order $order): Response
    {
        $form = $this->createForm(OrderDeliveryStatusType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($order->getDeliveryStatus() === 0)
                $order->setDeliveryNote(null);
            elseif ($order->getDeliveryStatus() === 1)
                $order->setDeliveryNote(bin2hex(random_bytes(6)));

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin.order.show', ['id' => $order->getId()]);
        }

        return $this->render('admin/order/update_delivery_status.html.twig', [
            'order' =>$order,
            'form' => $form->createView(),
        ]);
    }
}
