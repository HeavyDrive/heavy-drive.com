<?php

namespace AppBundle\Manager;

use AppBundle\Entity\BookingGuest;
use AppBundle\Entity\Car;
use AppBundle\Entity\Client;
use AppBundle\Entity\Reservation;
use AppBundle\Repository\ReservationRepository;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\ORM\EntityManager;
use FOS\UserBundle\Entity\User;

class ReservationManager
{
    /**
     * @var Registry
     */
    protected $registry;

    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var carManager
     */
    protected $carManager;

    /**
     * @var ReservationRepository
     */
    protected $reservationRepository;

    /**
     * ReservationManager constructor.
     *
     * @param Registry $registry
     */
    public function __construct(Registry $registry)
    {
        $this->registry      = $registry;
        $this->entityManager = $registry->getManagerForClass(Reservation::class);
        $this->reservationRepository = $registry->getRepository(Reservation::class);
    }

    /**
     * User can do an booking
     *
     * @param Client      $user
     * @param Reservation $reservation
     *
     * @return bool
     */
    public function canBooking(Reservation $reservation)
    {
        if (!$reservation instanceof Reservation)
        {
            return false;
        }

        return true;
    }

    /**
     * Create an booking
     *
     * @param Reservation $reservation
     * @param Car $car
     * @param \DateTime $dateStart
     * @param \DateTime $dateEnd
     */
    public function Booking(Reservation $reservation, $dateStart, $dateEnd)
    {
        $reservation->setDateStart($dateStart);
        $reservation->setDateEnd($dateEnd);
        $reservation->setStatus(Reservation::STATUS_CREATED);
        /*$car->setStatus(Car::STATUS_BUSY);
        $reservation->setCar($car);*/
    }

    /**
     * Save an booking
     *
     * @param Reservation $reservation
     * @param bool        $flush
     */
    public function save(Reservation $reservation, $flush = false)
    {
        $em = $this->entityManager->persist($reservation);
        $this->entityManager->flush($em);
    }

    /**
     * @param Car         $car
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function isValidForDate(Car $car, $dateStart)
    {
        return $this->reservationRepository->getAvailabilityCarForDay($car, $dateStart)->getQuery()->getResult();
    }


    /*public function updatedStatus()
    {

    }*/

    public function canCancelledBooking()
    {

    }

    public function cancelledBooking()
    {

    }
}