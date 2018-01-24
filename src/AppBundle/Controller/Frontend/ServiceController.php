<?php

namespace AppBundle\Controller\Frontend;

use AppBundle\Entity\Car;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ServiceController extends Controller
{
    /**
     * @Route("/services", name="service")
     *
     */
    public function listServiceAction(){

        return $this->render('frontend/default/service.html.twig', []);
    }
    /**
     * @Route("/wedding", name="wedding")
     *
     */
    public function weddingAction(){

        /** @var \AppBundle\Repository\CarRepository $carRepository */
        $carRepository = $this->getDoctrine()->getRepository(Car::class);

        $cars = $carRepository->findAll();

        return $this->render('frontend/default/wedding.html.twig', [
            'cars' => $cars
        ]);
    }
}
