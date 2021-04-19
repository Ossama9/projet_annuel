<?php


namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{

    /**
     * @var ObjectManager
     */
    private ObjectManager $em;
    /**
     * @var UserRepository
     */
    private UserRepository $repository;

    public function __construct(UserRepository $repository, ObjectManager $em)
    {
        $this->em = $em;
        $this->repository = $repository;
    }

    /**
     * @Route("/account", name="account.index")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $form = $this->createForm(UserType::class, $this->getUser());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            $this->addFlash('success', 'Les modifications ont bien été prises en compte.');
            return $this->redirectToRoute('account.index');
        }

        return $this->render('account/index.html.twig', [
            'user' => $this->getUser(),
            'form' => $form->createView(),
            'current_page' => 'account'
        ]);
    }

    /**
     * @Route("account/delete", name="account.delete", methods={"POST"})
     * @param Request $request
     * @param UserRepository $userRepository
     * @return Response
     */
    public function delete(Request $request, UserRepository $userRepository): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $user = $userRepository->findOneBy(['username' => $this->getUser()->getUsername()]);

        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();

            return $this->redirectToRoute('account.deleted');
        }

        return $this->redirectToRoute('home');
    }

    /**
     * @Route("account/deleted", name="account.deleted")
     * @return Response
     */
    public function accountDeleted(): Response
    {
        return $this->render('account:deleted.html.twig');
    }
}