<?php

namespace App\Controller\Admin;

use App\Entity\Order;
use App\Entity\Wharehouse;
use App\Form\CartType;
use App\Form\WharehouseType;
use App\Repository\OrderRepository;
use App\Repository\WharehouseRepository;
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
}
