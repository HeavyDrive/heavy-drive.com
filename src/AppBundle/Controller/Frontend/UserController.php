<?php

namespace AppBundle\Controller\Frontend;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * @Route("/connection", name="connection")
     *
     */
    public function connectionAction(){

        return $this->render('frontend/user/connection.html.twig', []);
    }

    /**
     * @Route("/registration", name="Registration")
     *
     */
    public function registrationAction(){

        return $this->render('frontend/user/register.html.twig', []);
    }

}