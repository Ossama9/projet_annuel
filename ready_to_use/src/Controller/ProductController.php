<?php

namespace App\Controller;

use App\Entity\Product;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;


class ProductController extends AbstractController
{


    /**
     * @Route("/sell", name="sell")
     * @return Response
     */



    public function index() : Response
    {
        $product = new Product();
        return $this->render('pages/product.html.twig');

    }
}