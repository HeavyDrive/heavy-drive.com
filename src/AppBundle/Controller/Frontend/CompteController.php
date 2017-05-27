<?php

namespace AppBundle\Controller\Frontend;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CompteController extends Controller
{
    /**
     * @Route("/compte", name="compte")
     *
     */
    public function CompteAction()
    {

        return $this->render('frontend/user/compte.html.twig', []);
    }


    /**
     * @Route("/compte/historique", name="historique")
     *
     */
    public function HistoryAction()
    {

        return $this->render('frontend/user/historique.html.twig', []);
    }

}
