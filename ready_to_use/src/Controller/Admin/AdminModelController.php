<?php

namespace App\Controller\Admin;

use App\Entity\Brand;
use App\Entity\Model;
use App\Entity\Wharehouse;
use App\Form\BrandType;
use App\Form\ModelType;
use App\Form\WharehouseType;
use App\Repository\BrandRepository;
use App\Repository\ModelRepository;
use App\Repository\WharehouseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/model")
 */
class AdminModelController extends AbstractController
{
    /**
     * @Route("/", name="admin.model.index", methods={"GET"})
     * @param ModelRepository $modelRepository
     * @return Response
     */
    public function index(ModelRepository $modelRepository): Response
    {
        return $this->render('admin/model/index.html.twig', [
            'models' => $modelRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin.model.new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $model = new Model();
        $form = $this->createForm(ModelType::class, $model);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($model);
            $entityManager->flush();

            return $this->redirectToRoute('admin.model.index');
        }

        return $this->render('admin/model/new.html.twig', [
            'model' => $model,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin.model.show", methods={"GET"})
     * @param Model $model
     * @return Response
     */
    public function show(Model $model): Response
    {
        return $this->render('admin/model/show.html.twig', [
            'model' => $model,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin.model.edit", methods={"GET","POST"})
     * @param Request $request
     * @param Model $model
     * @return Response
     */
    public function edit(Request $request, Model $model): Response
    {
        $form = $this->createForm(ModelType::class, $model);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin.model.index');
        }

        return $this->render('admin/model/edit.html.twig', [
            'model' => $model,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin.model.delete", methods={"POST"})
     * @param Request $request
     * @param Model $model
     * @return Response
     */
    public function delete(Request $request, Model $model): Response
    {
        if ($this->isCsrfTokenValid('delete'.$model->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($model);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin.model.index');
    }
}
