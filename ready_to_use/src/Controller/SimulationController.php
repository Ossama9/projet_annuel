<?php

namespace App\Controller;

use App\Entity\Brand;
use App\Entity\Model;
use App\Entity\Product;
use App\Controller\TextType;
use App\Entity\Task;
use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Form\SimulationType;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Validator\Constraints\Date;

class SimulationController extends AbstractController
{

    /**
     * @Route("/simulation", name="simulation")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
//        var_dum;
        // creates a task object and initializes some data for this example
        $form = $this->createForm(SimulationType::class );

//        $model = new Model();
//        $brand = new Brand();

        $models = $this->getDoctrine()->getManager()->getRepository(Model::class)->findAll();
        $brands = $this->getDoctrine()->getManager()->getRepository(Brand::class)->findAll();
        if ($request->isMethod('POST')&&$form->handleRequest($request)->isValid()) {
            $model = $_POST['model'];
            $model= $this->getDoctrine()->getManager()->getRepository(Model::class)->find($model);
            $price = $model->getPrice();
            if ($_POST['batterie'] == 1){
                $price *= 0.95;
            }
            elseif ($_POST['batterie'] == 2){
                $price *= 0.90;
            }
            elseif ($_POST['batterie'] == 3){
                $price *= 0.80;
            }
            if ($_POST['ecran'] == 1){
                $price *= 0.95;
            }
            elseif ($_POST['ecran'] == 2){
                $price *= 0.90;
            }
            elseif ($_POST['ecran'] == 3){
                $price *= 0.80;
            }
//            echo $price . " €";
            if ($this->getUser()->getId())
                $id =  $this->getUser()->getId();echo $id;
        }

//        isset($_POST['batterie']) ? $_POST['batterie'] : null;


//        $em = $this->getDoctrine()->getManager();
//        $em->persist($model);
//        $em->flush();
//        echo $model->getName();


        return $this->render("product/simulation.html.twig",[
            'form' => $form->createView(),
            'models'=> $models,
            'brands'=> $brands,
            'current_page' => 'simulation'

        ]);
    }

}
