<?php


namespace App\Controller;

use App\Entity\UserVerification;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Repository\UserVerificationRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{

    /**
     * @var UserRepository
     */
    private UserRepository $repository;

    /**
     * @var UserVerificationRepository
     */
    private UserVerificationRepository $verificationRepository;

    /**
     * @var ObjectManager
     */
    private ObjectManager $em;

    public function __construct(UserRepository $repository, UserVerificationRepository $verificationRepository, ObjectManager $em)
    {
        $this->repository = $repository;
        $this->verificationRepository = $verificationRepository;
        $this->em = $em;
    }

    /**
     * @Route("/account", name="account.index")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        $is_merchant = $this->verificationRepository->findOneBy(['requestingUser' => $user]);
        $merchant = $is_merchant ? $is_merchant->getStatus() === 1 ? $is_merchant : false : false;

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            $this->addFlash('success', 'Les modifications ont bien été prises en compte.');
            return $this->redirectToRoute('account.index');
        }

        return $this->render('account/index.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
            'merchant' => $merchant,
            'current_page' => 'account'
        ]);
    }

    /**
     * @Route("account/delete", name="account.delete", methods={"POST"})
     * @param Request $request
     * @return Response
     */
    public function delete(Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $user = $this->repository->findOneBy(['username' => $this->getUser()->getUsername()]);

        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {

            $this->em->remove($user);
            $this->em->flush();

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

    /**
     * Permet à un utilisateur de devenir marchand
     * @Route("account/merchant", name="account.merchant", methods={"POST"})
     * @param Request $request
     * @return Response
     */
    public function merchant(Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->repository->findOneBy(['username' => $this->getUser()->getUsername()]);

        if ($this->isCsrfTokenValid('request'.$user->getId(), $request->request->get('_token'))) {

            $userVerification = new UserVerification();
            $userVerification->setStatus(0);
            $userVerification->setRequestDate(new \DateTime());
            $userVerification->setRequestingUser($user);
            $this->em->persist($userVerification);
            $this->em->flush();
            $this->addFlash('success', 'Votre demande a bien été prise en compte. Un administrateur va traiter votre demande dans les plus brefs délais.');

        }

        return $this->redirectToRoute('account.index');
    }
}