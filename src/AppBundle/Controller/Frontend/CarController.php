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
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class CarController extends Controller
{
    /**
     * @Route("/car", name="car")
     *
     * @return Response
     */
    public function showAction()
    {
        $carRepository = $this->getDoctrine()->getRepository( Car::class);

        $cars = $carRepository->findAll();

        return $this->render('frontend/car/show.html.twig', [
            'cars' => $cars
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
        $car = $carRepository->findById($car);

        return $this->render('frontend/car/details.html.twig', [
            'car' => $car
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
