<?php

namespace App\Controller\Admin;

use App\Entity\Brand;
use App\Entity\Wharehouse;
use App\Form\BrandType;
use App\Form\WharehouseType;
use App\Repository\BrandRepository;
use App\Repository\WharehouseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/brand")
 */
class AdminBrandController extends AbstractController
{
    /**
     * @Route("/", name="admin.brand.index", methods={"GET"})
     * @param BrandRepository $brandRepository
     * @return Response
     */
    public function index(BrandRepository $brandRepository): Response
    {
        return $this->render('admin/brand/index.html.twig', [
            'brands' => $brandRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin.brand.new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $brand = new Brand();
        $form = $this->createForm(BrandType::class, $brand);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($brand);
            $entityManager->flush();

            return $this->redirectToRoute('admin.brand.index');
        }

        return $this->render('admin/brand/new.html.twig', [
            'brand' => $brand,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin.brand.show", methods={"GET"})
     * @param Brand $brand
     * @return Response
     */
    public function show(Brand $brand): Response
    {
        return $this->render('admin/brand/show.html.twig', [
            'brand' => $brand,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin.brand.edit", methods={"GET","POST"})
     * @param Request $request
     * @param Brand $brand
     * @return Response
     */
    public function edit(Request $request, Brand $brand): Response
    {
        $form = $this->createForm(BrandType::class, $brand);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin.brand.index');
        }

        return $this->render('admin/brand/edit.html.twig', [
            'brand' => $brand,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin.brand.delete", methods={"POST"})
     * @param Request $request
     * @param Brand $brand
     * @return Response
     */
    public function delete(Request $request, Brand $brand): Response
    {
        if ($this->isCsrfTokenValid('delete'.$brand->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($brand);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin.brand.index');
    }
}
