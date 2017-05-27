<?php

namespace AppBundle\Controller\Frontend;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PartenaireController extends Controller
{
    /**
     * @Route("/partenaires", name="partenaires")
     */
    public function partAction()
    {
        return $this->render('frontend/default/partenaires.html.twig');
    }
}
