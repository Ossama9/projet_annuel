<?php


namespace App\Controller;

use App\Entity\Model;
use App\Entity\Order;
use App\Entity\Picture;
use App\Form\AddToCartType;
use App\Form\FilterType;
use App\Manager\CartManager;
use App\Repository\BrandRepository;
use App\Repository\ModelRepository;
use App\Repository\SellRepository;
use App\Repository\UserVerificationRepository;
use DateTime;
use App\Entity\Product;
use App\Entity\User;
use Exception;
use Stripe\Checkout\Session;
use Stripe\Exception\ApiErrorException;
use Stripe\Stripe;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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
     * @param Request $request
     * @param BrandRepository $brandRepo
     * @return Response
     */
    public function index(Request $request, BrandRepository $brandRepo): Response
    {
        $brands = $brandRepo->findAll();
        $products = $this->getDoctrine()->getRepository(Product::class)->findAcceptedProducts();

        $form = $this->createForm(FilterType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $chosenModel = $form->get("model")->getData();
            $maxPrice = $form->get("max_price")->getData();
            $products = $this->getDoctrine()->getRepository(Product::class)->findWithFilters($chosenModel, $maxPrice);
        }

        return $this->render('/product/index.html.twig', [
            "brands" => $brands,
            'products' => $products,
            "form" => $form->createView(),
            'current_page' => 'product'
        ]);

    }

    /**
     * @Route("", name="product.ajax", methods={"POST"})
     * @param BrandRepository $brandRepo
     * @param Request $request
     * @return Response
     */
    public function ajaxAction( BrandRepository $brandRepo,
                                Request $request
    ){

        $brandId = $request->request->get("brand_id");
        $brand = $brandRepo->find($brandId);
        $models = $brand->getModels();

        $form = $this->createForm(FilterType::class);
        $form->add("model", EntityType::class, [
            "class" => Model::class,
            "choice_label" => "name",
            "choices" => $models
        ]);

        return  $this->render("/product/_filter_form.html.twig", [
            "form" =>$form->createView()
        ]);
    }


    /**
     * @Route("/{id}", name="product.show")
     * @param Product $product
     * @param Request $request
     * @param CartManager $cartManager
     * @return Response
     * @throws Exception
     */
    public function show(Product $product, Request $request, CartManager $cartManager): Response
    {
        $form = $this->createForm(AddToCartType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $item = $form->getData();
            $item->setProduct($product);

            $cart = $cartManager->getCurrentCart();
            $cart
                ->addProduct($item)
                ->setRequestDate(new \DateTime());

            $cartManager->save($cart);

            $message = 'Le produit a bien été ajouté au panier.';

            $this->addFlash('success', $message);
            return $this->redirectToRoute('product.show', ['id' => $product->getId()]);
        }

        $pictures = $this->getDoctrine()->getRepository(Picture::class)->findBy(['product' => $product]);

        return $this->render('/product/show.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
            'pictures' => $pictures,
            'current_page' => 'product'
        ]);
    }

}