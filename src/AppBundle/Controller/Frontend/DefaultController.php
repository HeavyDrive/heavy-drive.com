<?php

namespace AppBundle\Controller\Frontend;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{

    public function __construct()
    {

    }

    /**
     * @Route("/", name="homepage")
     *
     * @param Request $request
     *
     * @return RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        return $this->render('frontend/default/index.html.twig', []);
    }

    /**
     * @Route("/contact", name="contact")
     *
     */
    public function contactAction()
    {
        return $this->render('frontend/default/contact.html.twig');
    }

    /**
     * @Route("/storage", name="storage")
     *
     */
    public function storageAction()
    {
        $cloudStorage = $this->container->get('app.services.google_cloud');

        dump($cloudStorage);
    }
}
