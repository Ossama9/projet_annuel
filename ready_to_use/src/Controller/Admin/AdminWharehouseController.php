<?php

namespace App\Controller\Admin;

use App\Entity\Wharehouse;
use App\Form\WharehouseType;
use App\Repository\WharehouseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/wharehouse")
 */
class AdminWharehouseController extends AbstractController
{
    /**
     * @Route("/", name="admin.wharehouse.index", methods={"GET"})
     * @param WharehouseRepository $wharehouseRepository
     * @return Response
     */
    public function index(WharehouseRepository $wharehouseRepository): Response
    {
        return $this->render('admin/wharehouse/index.html.twig', [
            'wharehouses' => $wharehouseRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin.wharehouse.new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $wharehouse = new Wharehouse();
        $form = $this->createForm(WharehouseType::class, $wharehouse);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($wharehouse);
            $entityManager->flush();

            return $this->redirectToRoute('admin.wharehouse.index');
        }

        return $this->render('admin/wharehouse/new.html.twig', [
            'wharehouse' => $wharehouse,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin.wharehouse.show", methods={"GET"})
     * @param Wharehouse $wharehouse
     * @return Response
     */
    public function show(Wharehouse $wharehouse): Response
    {
        return $this->render('admin/wharehouse/show.html.twig', [
            'wharehouse' => $wharehouse,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin.wharehouse.edit", methods={"GET","POST"})
     * @param Request $request
     * @param Wharehouse $wharehouse
     * @return Response
     */
    public function edit(Request $request, Wharehouse $wharehouse): Response
    {
        $form = $this->createForm(WharehouseType::class, $wharehouse);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin.wharehouse.index');
        }

        return $this->render('admin/wharehouse/edit.html.twig', [
            'wharehouse' => $wharehouse,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin.wharehouse.delete", methods={"POST"})
     * @param Request $request
     * @param Wharehouse $wharehouse
     * @return Response
     */
    public function delete(Request $request, Wharehouse $wharehouse): Response
    {
        if ($this->isCsrfTokenValid('delete'.$wharehouse->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($wharehouse);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin.wharehouse.index');
    }
}
