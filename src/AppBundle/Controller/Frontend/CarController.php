<?php

namespace AppBundle\Controller\Frontend;

use AppBundle\Entity\Car;
use AppBundle\Entity\Price;
use AppBundle\Entity\Reservation;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class CarController extends Controller
{
    /**
     * @Route("/car", name="car")
     */
    public function showAction()
    {
        return $this->render('frontend/car/show.html.twig');
    }
    /**
     * @Route("/details", name="details")
     */
    public function detailsAction()
    {
        return $this->render('frontend/car/details.html.twig');
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
