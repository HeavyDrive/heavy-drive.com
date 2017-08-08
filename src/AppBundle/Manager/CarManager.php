<?php
/**
 * Created by PhpStorm.
 * User: ashley
 * Date: 03/06/17
 * Time: 14:49
 */

namespace AppBundle\Manager;


use AppBundle\Entity\Car;
use AppBundle\Entity\Client;
use AppBundle\Entity\Price;
use AppBundle\Entity\Reservation;
use AppBundle\Entity\Service;
use AppBundle\Repository\CarRepository;
use AppBundle\Repository\PriceRepository;
use AppBundle\Repository\ReservationRepository;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;

class CarManager
{
    /**
     * @var Registry
     */
    protected $registry;

    /**
     * @var ReservationRepository
     */
    protected $reservationRepository;

    /**
     * @var PriceRepository
     */
    protected $priceRepository;

    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * CarManager constructor.
     *
     * @param Registry      $registry
     */
    public function __construct(Registry $registry)
    {
        $this->registry              = $registry;
        $this->entityManager         = $registry->getManagerForClass(Reservation::class);
        $this->reservationRepository = $registry->getRepository(Reservation::class);
        $this->priceRepository       = $registry->getRepository(Price::class);
        //$this->priceRepository         = $registry->getRepository(Price::class);
    }

    /**
     * List my booking cars was done.
     *
     * @param Client $user
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function listHistoricBookingCars(Client $user)
    {
        return $this->reservationRepository->getReservationHistoricByClient($user)->getQuery()->getResult();
    }

    /**
     * List my booking cars.
     *
     * @param Client $user
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function listBookingCars(Client $user)
    {
        return $this->reservationRepository->getReservationByClient($user)->getQuery()->getResult();
    }

    public function listPriceCarByService($service, $car)
    {
        return $this->priceRepository->getPriceCarByService($service, $car)->getQuery()->getResult();
    }
}

