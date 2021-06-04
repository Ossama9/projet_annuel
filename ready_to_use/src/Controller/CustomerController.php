<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\FilterType;
use App\Repository\BrandRepository;
use App\Repository\ModelRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/customer")
 */
class CustomerController extends AbstractController
{
    /**
     * @Route("/", name="customer.index")
     * @param ProductRepository $productRepo
     * @param BrandRepository $brandRepo
     * @param ModelRepository $modelRepo
     * @param Request $request
     * @return Response
     */
    public function index(  ProductRepository $productRepo,
                            BrandRepository $brandRepo,
                            ModelRepository $modelRepo,
                            Request $request
    ){
        $brands = $brandRepo->findAll();
        $models = $modelRepo->findAll();

        $form = $this->createForm(FilterType::class);

        return $this->render("/customer/index.html.twig", [
            "brands" => $brands,
            "models" => $models,
            "form" => $form->createView(),
            "current_page" => "product"
        ]);
    }

    /**
     * @Route("/list", name="customer.list", methods={"POST"})
     * @param BrandRepository $brandRepo
     * @param ModelRepository $modelRepo
     * @param Request $request
     * @return Response
     */
    public function list(   BrandRepository $brandRepo,
                            ModelRepository $modelRepo,
                            Request $request
    ){
        $brands = $brandRepo->findAll();
        $models = $modelRepo->findAll();

        $form = $this->createForm(FilterType::class);

        if($request->isMethod('POST')){
            $chosenModel = $request->request->get("model");
            $maxPrice = $request->request->get("max_price");
        }

        $products = $this->getDoctrine()->getRepository(Product::class)->findWithFilters($chosenModel, $maxPrice);

        return $this->render("/customer/list.html.twig", [
            "brands" => $brands,
            "models" => $models,
            "products" => $products,
            "form" => $form
        ]);
    }

    /**
     * @Route("/show", name="customer.show", methods={"POST"})
     * @param ProductRepository $productRepo
     * @param Request $request
     * @return Response
     */
    public function show(   ProductRepository $productRepo,
                            Request $request
    ){
        if($request->isMethod('POST')){
            $productId = $request->request->get("product_id");
        }
        $product = $this->getDoctrine()->getRepository(Product::class)->find($productId);

        $array = $product->getModel()->getFeature()->toArray();

        return $this->render("/customer/show.html.twig", [
            "product" => $product,
            "features" => $array
        ]);
    }
}