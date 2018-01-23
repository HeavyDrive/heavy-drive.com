<?php

namespace AppBundle\Controller\Frontend;

use AppBundle\Entity\Car;
use AppBundle\Entity\Contact;
use AppBundle\Entity\Price;
use AppBundle\Entity\Reservation;
use AppBundle\Entity\Service;
use AppBundle\Form\Type\ContactType;
use AppBundle\Repository\ReservationRepository;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class CarController extends Controller
{
    /**
     * @Route("/show-car", name="car")
     *
     * @return Response
     */
    public function showAction(Request $request)
    {

        $form = $this->get('form.factory')->createBuilder()
            ->add('agency', 'entity', array(
                    'class' => 'AppBundle:Agency',
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('a')
                            ->groupBy('a.id')
                            ->orderBy('a.name', 'ASC');
                    },)
            )
            ->add('agencyRetour', 'entity', array(
                    'class' => 'AppBundle:Agency',
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('a')
                            ->groupBy('a.id')
                            ->orderBy('a.name', 'ASC');
                    },)
            )
            ->add('startDate', DateTimeType::class, [
                'data' => new \DateTime('now'), //default value
                'format' => 'dd-MM-yyyy HH:mm:ss',
                'model_timezone' => 'Europe/Paris',
                'widget' => 'single_text',
                'attr' => ['class' => 'js-datepicker1 form-control'],
            ])
            ->add('endDate', DateTimeType::class, [
                'data' => new \DateTime('now'), //default value
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy HH:mm:ss',
                'model_timezone' => 'Europe/Paris',
                'attr' => ['class' => 'js-datepicker2 form-control'],
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Rechercher votre véhicule',
                'attr' => array('class' => 'btn btn-default'),
            ])->getForm();

        $form->handleRequest($request);

        $agency = $form->get('agency')->getData();
        $dateStart =  $form->get('startDate')->getData();
        $dateEnd = $form->get('endDate')->getData();

        $cars = array();


        if ($form->isValid() && $form->isSubmitted()) {

            $em = $this->getDoctrine()->getManager(); // ...or getEntityManager() prior to Symfony 2.1

            $query = $em->createQuery("SELECT DISTINCT c.id, r.dateStart, r.dateEnd
                                       FROM AppBundle:Car c 
                                       JOIN AppBundle:Reservation r 
                                       WHERE c.id = r.car 
                                       AND r.dateStart <= :dateStart AND r.dateEnd >= :dateEnd
                                       OR r.dateStart > :dateStart AND r.dateEnd <= :dateEnd
                                       OR r.dateStart > :dateStart AND r.dateEnd = :dateEnd                                
                                      ");
            $query->setParameter('dateStart', $dateStart);
            $query->setParameter('dateEnd', $dateEnd);

            $listCars = $query->getResult();

            /** @var \AppBundle\Repository\CarRepository $carRepository */
            $carRepository = $this->getDoctrine()->getRepository(Car::class);

            if (!$listCars) {
                $cars = $carRepository->findAll();
            }
            else {
                $cars = $carRepository->getWhatYouWant($listCars);
            }
        }

        return $this->render('frontend/car/show.html.twig', [
            'form' => $form->createView(),
            'cars' => $cars,
            'dateStart' => $dateStart,
            'dateEnd' => $dateEnd
        ]);
    }



    /**
     * @Route("/car/{id}", name="car_details")
     * @ParamConverter("GET, POST", class="AppBundle\Entity\Car", options={"repository_method" = "findById"})
     *
     * @param Request $request
     * @param Car     $car
     *
     * @return Response
     */
    public function detailsAction(Request $request, Car $car)
    {
        /** @var \AppBundle\Repository\CarRepository $carRepository */
        $carRepository     = $this->getDoctrine()->getRepository(Car::class);

        /** @var \AppBundle\Repository\PriceRepository $priceRepository */
        $priceRepository   = $this->getDoctrine()->getRepository(Price::class);

        $priceCar = $priceRepository->getPriceCar($car);

        $car = $carRepository->findById($car);

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

        return $this->render('frontend/car/details.html.twig', [
            'car'     => $car,
            'priceCar'   => $priceCar,
            'form' => $form->createView()
        ]);
    }

    /**
     * list of cars was booking
     *
     * @Route("/my-booking-done", name="cars_booking_done")
     * @Security("is_granted('IS_AUTHENTICATED_ANONYMOUSLY')")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function listOfReservationDone(Request $request)
    {
        $carManager = $this->container->get('heavy.manager.car');

        $user = $this->getUser();

        $carsHasBooking = $carManager->listHistoricBookingCars($user);

        return $this->render("frontend\car\listHistoricBookingCars.html.twig", [
            "carHasBooking" => $carsHasBooking
        ]);
    }

    /**
     * list of cars booking
     *
     * @Route("/my-booking", name="cars_booking")
     * @Security("is_granted('IS_AUTHENTICATED_ANONYMOUSLY')")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function listOfReservation(Request $request)
    {
        $carManager = $this->container->get('heavy.manager.car');

        $user = $this->getUser();

        $carsBooking = $carManager->listBookingCars($user);

        return $this->render("frontend\car\listBookingCar.html.twig", [
            "carsBooking" => $carsBooking
        ]);
    }
}
