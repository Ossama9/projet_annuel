<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\AddProductType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;


class ProductController extends AbstractController
{
    /**
     * @Route("/sell", name="sell")
     * @param Request $request
     * @return Response
     */

    public function AddProduct(Request $request) : Response
    {
        $product = new Product();
        $form = $this->createForm(AddProductType::class,$product);
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $em->persist($product);
            $em->flush();

            $request->getSession()->getFlashBag()->add('Msg','Bien Ajouté');
            return $this->redirectToRoute('sell',["id"=>$product->getId()]);
            }


        return $this->render('product/list.html.twig',[
            'form' => $form->createView(),
            "Product"=>$product
        ]);
    }

    /**
     * @Route ("/list",name="list")
     * @param Request $request
     * @return Response
     */
    public function Afficher(Request $request) : Response
    {
        $products = $this->getDoctrine()->getRepository(Product::class)->findAll();

        return $this->render('product/list.html.twig', [
            'Product' => $products
        ]);
    }

//    /**
//     * @Route ("product/remove/{id}", name="remove")
//     * @param $id
//     * @return Response
//     */
//    public function Supprimer($id) : Response {
//        $em = $this->getDoctrine()->getManager();
//        $res = $em->getRepository(Product::class);
//        $Product = $res->find($id);
//        $em->remove($Product);
//        $em->flush();
//        $this->addFlash('danger', 'Produit a été bien supprimé');
//        return $this->redirectToRoute('list',[
//            "Product"=>$Product
//        ]);
//    }

}
