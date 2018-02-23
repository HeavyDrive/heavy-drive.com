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
                    ->setSubject('')
                    ->setFrom($this->get('form.type.email'))
                    ->setTo($this->container->getParameter('heavy.emails.contact_email'))
                    ->setBody($this->renderView('frontend/default/contactEmail.txt.twig', array('contact' => $contact)));
                try
                {
                    $this->get('mailer')->send($message);
                }

                catch (\Swift_TransportException $e)
                {
                    $result = array( false, 'There was a problem sending email: ' . $e->getMessage() );

                }

                $this->get('session')->getFlashBag()->Add('notice-car', 'Votre message a été correctement envoyé. Nous mettons tout en oeuvre pour vous répondre dans les meilleurs délais.');

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

    /**
     * @Route("/bill", name="bill")
     */
    public function billAction()
    {
        return $this->render('frontend/default/bill.html.twig');
    }

    /**
     * @Route("/pdf", name="pdf")
     */
    public function pdfAction()
    {
        $html = $this->renderView('AppBundle:Default:bill.html.twig');

        $filename = sprintf('test-%s.pdf', date('Y-m-d'));

        return new Response(
            $this->get('knp_snappy.pdf')->getOutputFromHtml($html),
            200,
            [
                'Content-Type'        => 'application/pdf',
                'Content-Disposition' => sprintf('attachment; filename="%s"', $filename),
            ]
        );
    }
}
