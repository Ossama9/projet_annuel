<?php

namespace App\Controller\Admin;

use App\Entity\UserVerification;
use App\Form\UserVerificationType;
use App\Repository\UserRepository;
use App\Repository\UserVerificationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/user-verification")
 */
class AdminUserVerificationController extends AbstractController
{
    /**
     * @var UserRepository
     */
    private UserRepository $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @Route("/", name="admin.user.verification.index", methods={"GET"})
     * @param UserVerificationRepository $userVerificationRepository
     * @return Response
     */
    public function index(UserVerificationRepository $userVerificationRepository): Response
    {
        return $this->render('admin/user_verification/index.html.twig', [
            'user_verifications' => $userVerificationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin.user.verification.new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $userVerification = new UserVerification();
        $form = $this->createForm(UserVerificationType::class, $userVerification);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            if ($userVerification->getStatus() === 1) {
                $userVerification->setValidationDate(new \DateTime());
                $verifiedBy = $this->repository->findOneBy(['username' => $this->getUser()->getUsername()]);
                $userVerification->setVerifiedBy($verifiedBy);
            }
            $entityManager->persist($userVerification);
            $entityManager->flush();

            return $this->redirectToRoute('admin.user.verification.index');
        }

        return $this->render('admin/user_verification/new.html.twig', [
            'user_verification' => $userVerification,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin.user.verification.show", methods={"GET"})
     * @param UserVerification $userVerification
     * @return Response
     */
    public function show(UserVerification $userVerification): Response
    {
        return $this->render('admin/user_verification/show.html.twig', [
            'user_verification' => $userVerification,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin.user.verification.edit", methods={"GET","POST"})
     * @param Request $request
     * @param UserVerification $userVerification
     * @return Response
     */
    public function edit(Request $request, UserVerification $userVerification): Response
    {
        $form = $this->createForm(UserVerificationType::class, $userVerification);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($userVerification->getStatus() === 1) {
                $userVerification->setValidationDate(new \DateTime());
                $verifiedBy = $this->repository->findOneBy(['username' => $this->getUser()->getUsername()]);
                $userVerification->setVerifiedBy($verifiedBy);
            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin.user.verification.index');
        }

        return $this->render('admin/user_verification/edit.html.twig', [
            'user_verification' => $userVerification,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin.user.verification.delete", methods={"POST"})
     * @param Request $request
     * @param UserVerification $userVerification
     * @return Response
     */
    public function delete(Request $request, UserVerification $userVerification): Response
    {
        if ($this->isCsrfTokenValid('delete'.$userVerification->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($userVerification);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin.user.verification.index');
    }
}
