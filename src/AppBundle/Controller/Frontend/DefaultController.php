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

    public function contactFormAction(Request $request)
    {
        $form = $this->createForm('AppBundle\Form\Type\ContactType',null,array(
            'action' => $this->generateUrl('heavy_contactform'),
            'method' => 'POST'
        ));

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                if ($this->sendEmail($form->getData())) {
                    return $this->redirectToRoute('heavy_contactform');
                } else {
                    var_dump("Erreur :(");
                }
            }
        }

        return $this->render('AppBundle:Default:details.html.twig', array(
            'form' => $form->createView()
        ));
    }

    private function sendEmail($data){
        $heavyContactMail = 'contact@heavy-drive.com';
        $heavyContactPassword = 'heavy';

        $transport = \Swift_SmtpTransport::newInstance('smtp.zoho.com', 465,'ssl')
            ->setUsername($heavyContactMail)
            ->setPassword($heavyContactPassword);

        $mailer = \Swift_Mailer::newInstance($transport);

        $message = \Swift_Message::newInstance("Our Contact Form ". $data["subject"])
            ->setFrom(array($heavyContactMail => "Message by ".$data["name"]))
            ->setTo(array(
                $heavyContactMail => $heavyContactMail
            ))
            ->setBody($data["message"]."<br>ContactMail :".$data["email"]);

        return $mailer->send($message);
    }
}
