<?php

namespace AppBundle\Controller\Frontend;

use AppBundle\Entity\Car;
use AppBundle\Entity\Contact;
use AppBundle\Entity\Price;
use AppBundle\Entity\Reservation;
use AppBundle\Entity\SearchCar;
use AppBundle\Entity\Service;
use AppBundle\Form\Type\ContactType;
use AppBundle\Form\Type\SearchCarsType;
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
     * @Route("/location/nos-vehicules", name="car")
     *
     * @return Response
     */
    public function showAction(Request $request)
    {
        $searchCars = new SearchCar();

        $form = $this->createForm(new SearchCarsType(), $searchCars);

        $cars = array();

        $dateStart = "";
        $dateEnd = "";

        if ('POST' == $request->getMethod()) {

            $form->handleRequest($request);

            $dateDebut = $form->get('startDate')->getData();
            $dateStart = $dateDebut->format('Y-m-d H:i:s');

            $dateFin = $form->get('endDate')->getData();
            $dateEnd = $dateFin->format('Y-m-d H:i:s');

            if(strtotime($dateStart) > strtotime($dateEnd)) {
                $this->get('session')->getFlashBag()->Add('notice-dateWeek', 'La date de fin est inférieure à la date de début');
            }

            //weekend ici : vendredi, samedi, dimanche
            if ($this->isWeekend($dateStart)) {
                if(strtotime($dateStart) + 2 * 3600 * 24 >= strtotime($dateEnd)){
                    $this->get('session')->getFlashBag()->Add('notice-dateWeek', 'Le week-end toute réservation doit être supérieur à 2 jours');
                } else {
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
            } else {

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
        }


        $price = 0;
        foreach ($cars as $value) {
            $price = $this->getPriceToPay($value);
        }

        dump($price);



        return $this->render('frontend/car/show.html.twig', [
            'form' => $form->createView(),
            'cars' => $cars,
            'dateStart' => $dateStart,
            'dateEnd' => $dateEnd,
            'price'=> $price
        ]);
    }


    /**
     * @Route("/location/vehicule/{id}/{mark}-{model}.html", name="car_details")
     * @ParamConverter("GET, POST", class="AppBundle\Entity\Car", options={"repository_method" = "findById"})
     *
     * @param Request $request
     * @param Car     $car
     *
     * @return Response
     */
    public function detailsAction(Request $request, Car $car, $mark, $model)
    {
        /** @var \AppBundle\Repository\CarRepository $carRepository */
        $carRepository     = $this->getDoctrine()->getRepository(Car::class);

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

                return $this->redirect($this->generateUrl('heavy_contact'));
            }
        }

        return $this->render('frontend/car/details.html.twig', [
            'car'     => $car,
            //'priceCar'   => $priceCar,
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

    public function isWeekend($date)
    {
        $weekDay = date('w', strtotime($date));
        return ($weekDay == 0 || $weekDay == 5 ||$weekDay == 6);
    }

    // fonction qui calcul un nouveau timestamp en fonction d'un timestamp et d'un decalage
    // 3600 * 24 = nombre de seconde par jour
    // $decalage = nombre de jour (positif ou negatif)
    function getNewDate($ma_date, $decalage) {
        return  $ma_date + ($decalage * 3600 * 24);
    }

    /**
     * @param $dateStart
     * @param $dateEnd
     * @param $car
     * @return array|int
     */
    public function getPriceToPay($car)
    {
        /** @var \AppBundle\Repository\PriceRepository $priceRepository */
        $priceRepository   = $this->getDoctrine()->getRepository(Price::class);

        $price = $priceRepository->getPriceCarByService(4, $car);

        return $price;

    }

}
