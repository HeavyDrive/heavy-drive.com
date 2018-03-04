<?php

namespace AppBundle\Controller\Frontend;

use AppBundle\Entity\Car;
use AppBundle\Entity\Contact;
use AppBundle\Entity\Price;
use AppBundle\Form\Type\ContactType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ServiceController extends Controller
{
    /**
     * @Route("/nos-services", name="service")
     *
     */
    public function listServiceAction(){

        return $this->render('frontend/default/service.html.twig', []);
    }

    /**
     * @Route("/location/vehicules/mariage", name="wedding")
     *
     * @return Response
     */
    public function weddingAction(){

        /** @var \AppBundle\Repository\CarRepository $carRepository */
        $carRepository = $this->getDoctrine()->getRepository(Car::class);

        $cars = $carRepository->findAll();

        /** @var \AppBundle\Repository\PriceRepository $priceRepository */
        $priceRepository   = $this->getDoctrine()->getRepository(Price::class);

        foreach ($cars as $car) {

            $priceCar = $priceRepository->getPriceCarForWeddingService($car);
        }

        // send form contact us
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

                $this->get('session')->getFlashBag()->Add('notice', 'Votre message a été correctement envoyé. Nous mettons tout en oeuvre pour vous répondre dans les meilleurs délais.');

                //return $this->redirect($this->generateUrl('heavy_contact'));
            }
        }

        return $this->render('frontend/default/wedding.html.twig', [
            'cars' => $cars,
            'priceCar'   => $priceCar,
            'form' => $form->createView()
        ]);
    }
}
