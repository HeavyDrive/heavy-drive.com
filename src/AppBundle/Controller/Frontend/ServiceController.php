<?php

namespace AppBundle\Controller\Frontend;

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

        return $this->render('frontend/default/wedding.html.twig', []);
    }
}
