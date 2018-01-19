<?php

namespace AppBundle\Controller\Frontend;

use AppBundle\Entity\Contact;
use AppBundle\Form\Type\ContactType;
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
        $contact = new Contact();
        $form = $this->createForm(new ContactType(), $contact);

        $request = $this->getRequest();

        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {

                $message = \Swift_Message::newInstance()
                    ->setSubject(' ')
                    ->setFrom(' ')
                    ->setTo('bonix.dan@gmail.com')
                    ->setBody($this->renderView('AppBundle:Default:contactEmail.txt.twig', array('contact' => $contact)));
                $this->get('mailer')->send($message);

                $this->get('session')->getFlashBag()->Add('notice', 'Votre message a été correctement envoyé. Merci !');

                return $this->redirect($this->generateUrl('heavy_contact'));
            }
        }

        return $this->render('frontend/default/contact.html.twig', array(
            'form' => $form->createView()
        ));


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

    /**
     * @Route("/faq", name="faq")
     *
     */
    public function faqAction()
    {
        return $this->render('frontend/default/faq.html.twig');
    }
}
