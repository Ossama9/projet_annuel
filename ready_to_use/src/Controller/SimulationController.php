<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;


class SimulationController extends AbstractController
{


    /**
     * @Route("/simulation", name="simulation")
     * @return Response
     */



    public function index() : Response
    {
        return $this->render('pages/simulation.html.twig');

    }
}