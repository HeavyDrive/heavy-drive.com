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
use Symfony\Component\HttpFoundation\Session\Session;

class CarController extends Controller
{
    /**
     * @Route("/location/nos-vehicules", name="car")
     *
     * @return Response
     */
    public function showAction(Request $request)
    {
        $session = $request->getSession();

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

            $session->set('dateStart', $dateStart);
            $session->set('dateEnd', $dateEnd);

            if(strtotime($dateStart) > strtotime($dateEnd)) {
                $this->get('session')->getFlashBag()->Add('notice-dateWeek', 'La date de fin est inférieure à la date de début');
            }


            //weekend ici : vendredi, samedi, dimanche
            if ($this->isWeekend($dateStart)) {
                if(strtotime($dateStart) + 2 * 3600 * 23 <=  strtotime($dateEnd)){
                    $cars = $this->getAvailableCar($dateStart, $dateEnd);
                    dump($cars);
                }  else {
                    $this->get('session')->getFlashBag()->Add('notice-dateWeek', 'Le week-end toute réservation doit être supérieur à 2 jours');
                }
            }
            else {
                $cars = $this->getAvailableCar($dateStart, $dateEnd);
            }
        }

        /** @var \AppBundle\Repository\PriceRepository $priceRepository */
        $priceRepository   = $this->getDoctrine()->getRepository(Price::class);

        return $this->render('frontend/car/show.html.twig', [
            'form' => $form->createView(),
            'cars' => $cars,
            'dateStart' => $dateStart,
            'dateEnd' => $dateEnd,
            'priceRepository'=> $priceRepository
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
        $session = $request->getSession();
        $session->set('car', $car);

        /** @var \AppBundle\Repository\CarRepository $carRepository */
        $carRepository     = $this->getDoctrine()->getRepository(Car::class);

        // Find car by id
        $car = $carRepository->findById($car);

        if ($this->isWeekend($session->get('dateStart'))) {
            $price = $this->priceWeekToPay($car, $session->get('dateStart'), $session->get('dateEnd'));
        } else {
            //Count day booked car and calcul price
            $price = $this->priceToPay($car, $session->get('dateStart'), $session->get('dateEnd'));
        }

        $caution = $this->cautionToPay($car);
        $accompte = $this->accompteToPay($price);

        $session->set('priceTotalToPay', $price);
        $session->set('cautionToPay', $caution);
        $session->set('accompte', $accompte);

        $dateStart = $session->get('dateStart');
        $dateEnd = $session->get('dateEnd');
        $caution = $session->get('cautionToPay');


        // send form contact us
        $contact = new Contact();
        $form = $this->createForm(new ContactType(), $contact);

        $request = $this->getRequest();

        return $this->render('frontend/car/details.html.twig', [
            'car'     => $car,
            'price'   => $price,
            'form' => $form->createView(),
            'dateStart' => $dateStart,
            'dateEnd' => $dateEnd,
            'caution' => $caution,
            'accompte' => $accompte
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
    public function listOfReservationDoneAction(Request $request)
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
    public function listOfReservationAction(Request $request)
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

    public function priceToPay($car, $date1, $date2)
    {
        /** @var \AppBundle\Repository\PriceRepository $priceRepository */
        $priceRepository   = $this->getDoctrine()->getRepository(Price::class);

        $priceCar = $priceRepository->getPriceCar($car);

        $price = (int)$priceCar[0]["totalPrice"];

        // On transforme les 2 dates en timestamp
        $date1 = strtotime($date1);
        $date2 = strtotime($date2);

        $heureDateStart = date("G", $date1);
        $heureDateFin = date("G", $date2);

        // On récupère la différence de timestamp entre les 2 précédents
        $nbJoursTimestamp = $date2 - $date1;

        // ** Pour convertir le timestamp (exprimé en secondes) en jours **
        // On sait que 1 heure = 60 secondes * 60 minutes et que 1 jour = 24 heures donc :
        $nbJours = $nbJoursTimestamp/86400; // 86 400 = 60*60*24

        if ($nbJours >= 1) {
            if ($heureDateStart < 12 && $heureDateFin < 14 || $heureDateStart > 14 && $heureDateFin > 14) {
                dump($heureDateFin); dump($heureDateStart);
                $price = $price * $nbJours;
                dump($price);
            }elseif ($heureDateStart < 12 && $heureDateFin > 14 || $heureDateStart > 14 && $heureDateFin < 12) {
                $price = $price * $nbJours;
            }
        } else {
            return $price;
        }

        return $price;
    }

    public function priceWeekToPay ($car, $date1, $date2)
    {
        /** @var \AppBundle\Repository\PriceRepository $priceRepository */
        $priceRepository   = $this->getDoctrine()->getRepository(Price::class);

        $priceCar = $priceRepository->getPriceCar($car);

        $price = (int)$priceCar[0]["totalPrice"];
        $price2 = (int)$priceCar[2]["totalPrice"];

        // On transforme les 2 dates en timestamp
        $date1 = strtotime($date1);
        $date2 = strtotime($date2);

        // On récupère la différence de timestamp entre les 2 précédents
        $nbJoursTimestamp = $date2 - $date1;

        // ** Pour convertir le timestamp (exprimé en secondes) en jours **
        // On sait que 1 heure = 60 secondes * 60 minutes et que 1 jour = 24 heures donc :
        $nbJours = $nbJoursTimestamp/86400; // 86 400 = 60*60*24

        if ($nbJours === 2) {
            $price = $price * 2.5;
        } else {
            $price = $price2;
        }

        return $price;
    }

    public function cautionToPay($car)
    {
        /** @var \AppBundle\Repository\PriceRepository $priceRepository */
        $priceRepository   = $this->getDoctrine()->getRepository(Price::class);

        $cautionToPay = $priceRepository->getPriceCar($car);

        $cautionToPay = (int)$cautionToPay[0]["toPay"];

        return $cautionToPay;
    }

    public function accompteToPay($priceToPay)
    {
        $accompte = $priceToPay * 0.4;

        return $accompte;
    }

    public function unitPrice($car)
    {
        /** @var \AppBundle\Repository\PriceRepository $priceRepository */
        $priceRepository   = $this->getDoctrine()->getRepository(Price::class);

        $uniqPrice = $priceRepository->getPriceCar($car);

        return (int)$uniqPrice[0]["totalPrice"];
    }


    /**
     * @param $dateStart
     * @param $dateEnd
     *
     * @return array
     */
    public function getAvailableCar($dateStart, $dateEnd)
    {
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

        return $cars;
    }
}
