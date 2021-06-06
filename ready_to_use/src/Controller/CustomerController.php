<?php

namespace App\Controller;

use App\Entity\Model;
use App\Entity\Product;
use App\Form\FilterType;
use App\Repository\BrandRepository;
use App\Repository\ModelRepository;
use App\Repository\ProductRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
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
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $chosenModel = $form->get("model")->getData();
            $maxPrice = $form->get("max_price")->getData();
            $products = $this->getDoctrine()->getRepository(Product::class)->findWithFilters($chosenModel, $maxPrice);
        }
        else $products = null;

        return $this->render("/customer/list.html.twig", [
            "brands" => $brands,
            "models" => $models,
            "products" => $products,
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("", name="customer.ajax", methods={"POST"})
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

        return  $this->render("/customer/_filter_form.html.twig", [
            "form" =>$form->createView()
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