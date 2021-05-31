<?php

namespace App\Controller\Admin;

use App\Entity\Model;
use App\Entity\Offer;
use App\Entity\Picture;
use App\Entity\Product;
use App\Entity\Sell;
use App\Entity\Wharehouse;
use App\Form\AdminProductType;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/product")
 */
class AdminProductController extends AbstractController
{
    /**
     * @Route("/", name="admin.product.index")
     * @param ProductRepository $productRepository
     * @return Response
     */
    public function index(ProductRepository $productRepository): Response
    {
        return $this->render('admin/product/index.html.twig', [
            'products' => $productRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin.product.new")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $product = new Product();
        $form = $this->createForm(AdminProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $product->setDepositDate(new \DateTime());
            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('admin.product.index');
        }

        return $this->render('admin/product/new.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin.product.show")
     * @param Product $product
     * @return Response
     */
    public function show(Product $product): Response
    {
        $offer = $this->getDoctrine()->getRepository(Offer::class)->findOneBy([
            'productCondition' => $product->getProductCondition(),
            'model' => $product->getModel()
        ]);

        if ($offer) $referencePrice = $offer->getAmount();
        else $referencePrice = 0;

        $pictures = $this->getDoctrine()->getRepository(Picture::class)->findBy(['product' => $product]);

        return $this->render('admin/product/show.html.twig', [
            'product' => $product,
            'pictures' => $pictures,
            'referencePrice' => $referencePrice
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin.product.edit")
     * @param Request $request
     * @param Product $product
     * @return Response
     */
    public function edit(Request $request, Product $product): Response
    {
        $form = $this->createForm(AdminProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin.product.index');
        }

        return $this->render('admin/product/edit.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/delete", name="admin.product.delete", methods={"POST"})
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

        return $this->redirectToRoute('admin.product.index');
    }

    /**
     * Permet à un administrateur d'accepter une offre
     * @Route("/{id}/update-offer", name="admin.product.update_offer", methods={"POST"})
     * @param Request $request
     * @param Product $product
     * @return Response
     */
    public function updateOffer(Request $request, Product $product): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $sell = $product->getSell();

        if ($this->isCsrfTokenValid('accept_offer'.$product->getId(), $request->request->get('_token'))) {

            $product->setPrice($product->getPrice());
            $wharehouseRepository = $this->getDoctrine()->getRepository(Wharehouse::class);
            $wharehouses = $wharehouseRepository->findAll();

            $wharehouseId = [];
            foreach ($wharehouses as $wharehouse) $wharehouseId[] = $wharehouse->getId();

            // on choisit un entrepôt aléatoirement pour stocker le produit
            $randomWharehouse = $wharehouseRepository->find(rand(min($wharehouseId), max($wharehouseId)));
            $product->setWharehouse($randomWharehouse);

            $sell->setStatus(1);
            $sell->setAcceptedDate(new \DateTime());
            // bon colissimo
            $sell->setVoucher(bin2hex(random_bytes(6)));
            $this->addFlash('success', 'L\'offre a bien été accepté.');

        } else if ($this->isCsrfTokenValid('decline_offer'.$product->getId(), $request->request->get('_token'))) {

            $sell->setStatus(2);
            $this->addFlash('success', 'L\'offre a bien été refusé.');

        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($product);
        $entityManager->persist($sell);
        $entityManager->flush();

        return $this->redirectToRoute('admin.product.show', ['id' => $product->getId()]);
    }
}
