<?php


namespace App\Controller;

use App\Entity\Product;
use App\Entity\Sell;
use App\Entity\User;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use App\Repository\SellRepository;
use App\Repository\UserVerificationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/product")
 */
class ProductController extends AbstractController
{

    /**
     * @Route("/", name="product.index")
     * @param SellRepository $sellRepository
     * @param UserVerificationRepository $verificationRepository
     * @return Response
     */
    public function index(SellRepository $sellRepository, UserVerificationRepository $verificationRepository): Response
    {
        $is_merchant = $verificationRepository->findOneBy(['requestingUser' => $this->getUser()]);
        $merchant = $is_merchant ? $is_merchant->getStatus() === 1 ? $is_merchant : false : false;

        $products = [];
        $sells = $sellRepository->findBy(['soldBy' => $this->getUser()]);
        foreach ($sells as $sell) {
            $products[] = $sell->getProduct();
        }

        return $this->render('/product/index.html.twig', [
            'products' => $products,
            'current_page' => 'product',
            'merchant' => $merchant
        ]);

    }

    /**
     * @Route("/new", name="product.new")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $product->setDepositDate(new \DateTime());
            $sell = new Sell();
            $sell->setProduct($product);
            $sell->setStatus(0);
            $sell->setDepositDate($product->getDepositDate());
            $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['username' => $this->getUser()->getUsername()]);
            $sell->setSoldBy($user);
            $entityManager->persist($product);
            $entityManager->persist($sell);
            $entityManager->flush();

            return $this->redirectToRoute('product.index');
        }

        return $this->render('/product/new.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
            'current_page' => 'product'
        ]);
    }

    /**
     * @Route("/{id}", name="product.show")
     * @param Product $product
     * @return Response
     */
    public function show(Product $product): Response
    {
        return $this->render('/product/show.html.twig', [
            'product' => $product,
            'current_page' => 'product'
        ]);
    }

    /**
     * @Route("/{id}", name="product.delete", methods={"DELETE"})
     * @param Request $request
     * @param Product $product
     * @return Response
     */
    public function delete(Request $request, Product $product): Response
    {
        if ($this->isCsrfTokenValid('delete'.$product->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($product);
            $entityManager->flush();
        }

        return $this->redirectToRoute('product.index');
    }

}